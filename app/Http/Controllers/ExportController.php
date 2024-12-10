<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierItem;
use Illuminate\Http\Request;
use App\Models\SupplierItemDetail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function exportToCsv($guid)
    {
        $supplier = Supplier::findByGuid($guid);

        if (empty($supplier)) {
            return Redirect::back();
        }
        // Fetch the data
        $data = SupplierItem::findSupplierId($supplier->id);

        $totalPayment = SupplierItemDetail::where('supplier_id', $supplier->id)->sum('amount');

        // Prepare CSV headers
        $csvHeaders = ['Type', 'Date', 'Particular', 'Pcs/Qty', 'Size', 'Sq. Fit', 'Rate', 'Amount']; // Adjust column names

        $grandTotal = 0;
        // Prepare CSV content
        $csvData = $data->map(function ($item) use (&$grandTotal) {
            $amount = $item->amount; // Assuming amount is directly available
            $grandTotal += $amount; // Add to the grand total

            return [
                type($item->type),
                date('d-m-Y', strtotime($item->created_at)),
                $item->particular,
                $item->qty,
                !empty($item->size_1) ? $item->size_1 . 'X' . $item->size_2 : '-',
                !empty($item->size_3) ? $item->size_3 : '-',
                $item->rate,
                $amount,
            ];
        });

        // Add headers to CSV data
        $csvContent = implode(',', $csvHeaders) . "\n";
        foreach ($csvData as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        $csvContent .= "\n,,,,,,Grand Total," . $grandTotal;
        $csvContent .= "\n,,,,,,Paid Amount," . $totalPayment;
        $csvContent .= "\n,,,,,,Remaining Amount," . $grandTotal - $totalPayment;

        // Create a response with CSV data
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export.csv"',
        ]);
    }
}
