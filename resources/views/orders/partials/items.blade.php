{{--
    Order line items: Particular / Qty / Amount with "Add row" and a live total.

    @include('orders.partials.items', [
        'items' => [...],   // rows to show: [['particular'=>..,'qty'=>..,'amount'=>..], ...]
        'paid'  => 0,       // optional: amount already received (edit page), used for Balance
    ])

    Posts items[n][particular|qty|amount] and total_amount (sum of rows).
    If the form also has inputs with class .discount / .advance_amount,
    the summary shows Payable and Balance too.
--}}
@php
    $rows = old('items', $items ?? []);
    if (empty($rows)) {
        $rows = [['particular' => '', 'qty' => '', 'amount' => '']];
    }
    $paid = (float) ($paid ?? 0);
    $fmt = fn($v) => $v === null || $v === '' ? '' : rtrim(rtrim(number_format((float) $v, 2, '.', ''), '0'), '.');
@endphp

<div class="col-md-12">
    <div class="pp-items mb-3" data-paid="{{ $paid }}">
        <div class="pp-items-head">
            <label class="mb-0">Items*</label>
            <span class="pp-items-hint">Total amount is the sum of all rows.</span>
        </div>

        @error('items')
            <div class="alert alert-danger py-2 mb-2">{{ $message }}</div>
        @enderror

        <div class="table-responsive">
            <table class="table pp-items-table mb-0">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Particular</th>
                        <th style="width:140px">Qty</th>
                        <th style="width:180px">Amount (₹)</th>
                        <th style="width:56px"></th>
                    </tr>
                </thead>
                <tbody class="pp-items-body">
                    @foreach (array_values($rows) as $i => $row)
                        <tr class="pp-item-row">
                            <td class="pp-item-no align-middle">{{ $i + 1 }}</td>
                            <td>
                                <input type="text" name="items[{{ $i }}][particular]"
                                    value="{{ $row['particular'] ?? '' }}" placeholder="e.g. VISITING CARD"
                                    class="form-control pp-item-particular @error('items.' . $i . '.particular') is-invalid @enderror">
                                @error('items.' . $i . '.particular')
                                    <p class="invalid-feedback d-block mb-0">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input type="number" min="0" step="1" name="items[{{ $i }}][qty]"
                                    value="{{ $row['qty'] ?? '' }}" placeholder="Qty"
                                    class="form-control pp-item-qty @error('items.' . $i . '.qty') is-invalid @enderror">
                                @error('items.' . $i . '.qty')
                                    <p class="invalid-feedback d-block mb-0">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <input type="number" min="0" step="0.01" name="items[{{ $i }}][amount]"
                                    value="{{ $fmt($row['amount'] ?? '') }}" placeholder="0"
                                    class="form-control pp-item-amount @error('items.' . $i . '.amount') is-invalid @enderror">
                                @error('items.' . $i . '.amount')
                                    <p class="invalid-feedback d-block mb-0">{{ $message }}</p>
                                @enderror
                            </td>
                            <td class="text-right align-middle">
                                <button type="button" class="btn btn-sm btn-light pp-item-remove" title="Remove row"
                                    aria-label="Remove row"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pp-items-foot">
            <button type="button" class="btn btn-default pp-item-add">
                <i class="fas fa-plus mr-1"></i> Add row
            </button>

            <div class="pp-items-summary">
                <div><span>Total qty</span><strong class="pp-sum-qty">0</strong></div>
                <div class="pp-sum-main"><span>Total amount</span><strong class="pp-sum-total">₹0</strong></div>
                <div class="pp-sum-discount-row d-none"><span>Payable after discount</span><strong
                        class="pp-sum-payable">₹0</strong></div>
                <div class="pp-sum-balance-row d-none"><span>Balance</span><strong class="pp-sum-balance">₹0</strong>
                </div>
            </div>
        </div>

        {{-- Submitted total (the server recalculates it from the rows anyway) --}}
        <input type="hidden" name="total_amount" class="pp-total-input" value="">
    </div>
</div>

<template id="pp-item-template">
    <tr class="pp-item-row">
        <td class="pp-item-no align-middle"></td>
        <td><input type="text" data-field="particular" placeholder="e.g. VISITING CARD"
                class="form-control pp-item-particular"></td>
        <td><input type="number" min="0" step="1" data-field="qty" placeholder="Qty"
                class="form-control pp-item-qty"></td>
        <td><input type="number" min="0" step="0.01" data-field="amount" placeholder="0"
                class="form-control pp-item-amount"></td>
        <td class="text-right align-middle">
            <button type="button" class="btn btn-sm btn-light pp-item-remove" title="Remove row"
                aria-label="Remove row"><i class="fas fa-trash-alt"></i></button>
        </td>
    </tr>
</template>

@once
    @push('scripts')
        <script>
            (function($) {
                var $box = $('.pp-items');
                if (!$box.length) return;

                var $form = $box.closest('form');
                var $body = $box.find('.pp-items-body');
                var paid = parseFloat($box.data('paid')) || 0;

                function num(v) {
                    var n = parseFloat(v);
                    return isNaN(n) ? 0 : n;
                }

                function rupee(n) {
                    var neg = n < 0;
                    n = Math.abs(Math.round(n * 100) / 100);
                    var s = n.toLocaleString('en-IN', {
                        minimumFractionDigits: n % 1 ? 2 : 0,
                        maximumFractionDigits: 2
                    });
                    return (neg ? '-₹' : '₹') + s;
                }

                // Keep names sequential (items[0], items[1], ...) and row numbers in sync.
                function reindex() {
                    $body.find('.pp-item-row').each(function(i) {
                        $(this).find('.pp-item-no').text(i + 1);
                        $(this).find('input').each(function() {
                            var field = $(this).data('field') ||
                                ($(this).attr('name') || '').replace(/^items\[\d+\]\[(\w+)\]$/, '$1');
                            $(this).attr('name', 'items[' + i + '][' + field + ']').data('field', field);
                        });
                    });
                    var single = $body.find('.pp-item-row').length === 1;
                    $body.find('.pp-item-remove').prop('disabled', single);
                }

                function recalc() {
                    var total = 0,
                        qty = 0;
                    $body.find('.pp-item-row').each(function() {
                        total += num($(this).find('.pp-item-amount').val());
                        qty += num($(this).find('.pp-item-qty').val());
                    });
                    total = Math.round(total * 100) / 100;

                    $box.find('.pp-sum-total').text(rupee(total));
                    $box.find('.pp-sum-qty').text(qty);
                    $box.find('.pp-total-input').val(total);

                    var $discount = $form.find('.discount');
                    var $advance = $form.find('.advance_amount');
                    var discount = num($discount.val());
                    var payable = total - discount;

                    $box.find('.pp-sum-discount-row').toggleClass('d-none', !$discount.length);
                    $box.find('.pp-sum-payable').text(rupee(payable));

                    var showBalance = $advance.length || paid > 0;
                    var balance = payable - paid - num($advance.val());
                    $box.find('.pp-sum-balance-row').toggleClass('d-none', !showBalance);
                    $box.find('.pp-sum-balance').text(rupee(balance))
                        .toggleClass('text-danger', balance > 0).toggleClass('text-success', balance <= 0);
                }

                $box.on('click', '.pp-item-add', function() {
                    var $row = $($('#pp-item-template').html());
                    $body.append($row);
                    reindex();
                    recalc();
                    $row.find('.pp-item-particular').trigger('focus');
                });

                $box.on('click', '.pp-item-remove', function() {
                    if ($body.find('.pp-item-row').length <= 1) return;
                    $(this).closest('.pp-item-row').remove();
                    reindex();
                    recalc();
                });

                // Upper-case particulars, including rows added later.
                $box.on('input', '.pp-item-particular', function() {
                    var pos = this.selectionStart;
                    this.value = this.value.toUpperCase();
                    this.setSelectionRange(pos, pos);
                });

                // Enter in the last Amount field adds a new row instead of submitting.
                $box.on('keydown', '.pp-item-amount', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if ($(this).closest('.pp-item-row').is(':last-child')) {
                            $box.find('.pp-item-add').trigger('click');
                        } else {
                            $(this).closest('.pp-item-row').next().find('.pp-item-particular').trigger('focus');
                        }
                    }
                });

                $box.on('input', '.pp-item-amount, .pp-item-qty', recalc);
                $form.on('input change', '.discount, .advance_amount', recalc);

                reindex();
                recalc();
            })(jQuery);
        </script>
    @endpush
@endonce
