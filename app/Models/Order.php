<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    /**
     * Validation rules for the line-item rows posted as items[n][particular|qty|amount].
     */
    public static function itemRules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.particular' => 'required|string|max:255',
            'items.*.qty' => 'nullable|integer|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ];
    }

    public static function itemMessages(): array
    {
        return [
            'items.required' => 'Add at least one item.',
            'items.*.particular.required' => 'Particular is required.',
            'items.*.amount.required' => 'Amount is required.',
            'items.*.amount.numeric' => 'Amount must be a number.',
            'items.*.qty.integer' => 'Qty must be a whole number.',
        ];
    }

    /**
     * Drop rows the user left completely blank (so an empty trailing row
     * doesn't fail validation). Call before validating.
     */
    public static function cleanItems($items): array
    {
        return collect(is_array($items) ? $items : [])
            ->map(fn($row) => [
                'particular' => trim((string) ($row['particular'] ?? '')),
                'qty' => ($row['qty'] ?? '') === '' ? null : $row['qty'],
                'amount' => ($row['amount'] ?? '') === '' ? null : $row['amount'],
            ])
            ->reject(fn($row) => $row['particular'] === '' && $row['qty'] === null && $row['amount'] === null)
            ->values()
            ->all();
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class)->orderBy('sort')->orderBy('id');
    }

    /**
     * Fill particular / qty / total_amount from the rows (does not save).
     * total_amount is always the sum of row amounts.
     */
    public function fillFromItems(array $items): void
    {
        $particulars = collect($items)->pluck('particular')->filter()->implode(', ');

        $this->particular = mb_strimwidth($particulars, 0, 255, '…');
        $this->qty = collect($items)->sum(fn($r) => (int) ($r['qty'] ?? 0));
        $this->total_amount = round(collect($items)->sum(fn($r) => (float) ($r['amount'] ?? 0)), 2);
    }

    /**
     * Replace this order's line items with $items (order must be saved first).
     */
    public function syncProducts(array $items): void
    {
        DB::transaction(function () use ($items) {
            $this->products()->delete();
            foreach (array_values($items) as $i => $row) {
                $this->products()->create([
                    'particular' => $row['particular'],
                    'qty' => $row['qty'] ?? null,
                    'amount' => (float) $row['amount'],
                    'sort' => $i,
                ]);
            }
        });
    }

    /**
     * Rows for the edit form: saved line items, or one row built from the
     * legacy single-item fields for orders created before line items existed.
     */
    public function formItems(): array
    {
        $rows = $this->products->map(fn($p) => [
            'particular' => $p->particular,
            'qty' => $p->qty,
            'amount' => $p->amount,
        ])->all();

        if (empty($rows)) {
            $rows[] = [
                'particular' => $this->particular,
                'qty' => $this->qty,
                'amount' => $this->total_amount,
            ];
        }

        return $rows;
    }
}
