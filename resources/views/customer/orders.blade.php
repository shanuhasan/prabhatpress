@extends('layouts.app')
@section('title', 'Customer Orders')
@section('customers', 'active')


<?php
$customerDetail = getCustomerDetail($customerId);
?>
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders ({{ $customerDetail->name }}, {{ $customerDetail->company }}, {{ $customerDetail->phone }})
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('customer.orders.create', $customerId) }}" class="btn btn-primary">New Order</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('message')
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="{{ route('orders.index') }}" class="btn btn-danger">Reset</a>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword"
                                    class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Date</th>
                                <th>Delivery At</th>
                                <th>Particular</th>
                                <th>Qty</th>
                                <th>Total Amount</th>
                                {{-- <th>Balance Amount</th> --}}
                                <th>Order By</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($orders->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($orders as $order)
                                    <?php
                                    $advAmt = 0;
                                    $orderDetail = \App\Models\OrderItem::where('order_id', $order->id)->get();
                                    if (!empty($orderDetail)) {
                                        foreach ($orderDetail as $k => $vl) {
                                            $advAmt += $vl->amount;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><a
                                                href="{{ route('customer.orders.edit', ['customerId' => $customerId, 'orderId' => $order->id]) }}">{{ $order->order_no }}</a>
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                        <td>{{ !empty($order->delivery_at) ? date('d-m-Y', strtotime($order->delivery_at)) : '' }}
                                        </td>
                                        <td><a
                                                href="{{ route('customer.orders.edit', ['customerId' => $customerId, 'orderId' => $order->id]) }}">{{ $order->particular }}</a>
                                        </td>
                                        <td>{{ $order->qty }}</td>
                                        <td>₹{{ $order->total_amount }}</td>
                                        {{-- <td
                                            style="{{ $order->status == 'Complete' && $order->total_amount - $advAmt > 0 ? 'background:red;color:#fff;font-weight:bold;' : '' }}">
                                            ₹{{ $order->total_amount - $advAmt }}</td> --}}
                                        <td>{{ getUserName($order->created_by) }}</td>
                                        <td
                                            style="{{ $order->status == 'Pending' ? 'background:red;color:#fff;' : 'background:green;color:#fff;' }}">
                                            {{ $order->status }}</td>
                                        <td>
                                            <a
                                                href="{{ route('customer.orders.edit', ['customerId' => $customerId, 'orderId' => $order->id]) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="javascript:void()" onclick="deleteOrder({{ $order->id }})"
                                                class="text-danger w-4 h-4 mr-1">
                                                <svg wire:loading.remove.delay="" wire:target=""
                                                    class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path ath fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" align="center">Record Not Found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    @if ($orders->isNotEmpty())
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('customer.orders.payment') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $customerId }}" name="customer_id" id="customer_id">
                            <div class="card">
                                <div class="card-body">
                                    <span style="font-size: 24px;">Total Amount:- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>
                                            ₹{{ $totalAmount }}</strong><br>
                                        Received Amount:-
                                        <strong>₹{{ $totalAmountReceived + $customerTotalPayment }}</strong><br>
                                        Balance Amount:-
                                        &nbsp;&nbsp;<strong>₹{{ $totalAmount - ($totalAmountReceived + $customerTotalPayment) }}</strong></span>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="order_no">Amount</label>
                                                <input type="text" name="amount"
                                                    class="form-control @error('amount') is-invalid	@enderror"
                                                    placeholder="Amount">
                                                @error('amount')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="payment_method">Payment Method*</label>
                                                <select name="payment_method"
                                                    class="form-control @error('payment_method') is-invalid	@enderror"
                                                    id="payment_method">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Online">Online</option>
                                                </select>
                                                @error('payment_method')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 divHide inAccount">
                                            <div class="mb-3">
                                                <label for="in_account">Account*</label>
                                                <select name="in_account"
                                                    class="form-control @error('in_account') is-invalid	@enderror">
                                                    @foreach (getUsers() as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('in_account')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <section class="content">
                            <!-- Default box -->
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Received Amount</th>
                                                    <th>Payment Method</th>
                                                    <th>Account</th>
                                                    <th>Received By</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($customerPayment->isNotEmpty())
                                                    @foreach ($customerPayment as $item)
                                                        <tr>
                                                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                            <td>₹{{ $item->amount }}</td>
                                                            <td>{{ $item->payment_method }}</td>
                                                            <td>{{ getUserName($item->in_account) }}</td>
                                                            <td>{{ getUserName($item->updated_by) }}</td>
                                                            <td>
                                                                <a href="javascript:void()"
                                                                    onclick="deleteOrderItem({{ $item->id }},{{ $customerId }})"
                                                                    class="text-danger w-4 h-4 mr-1">
                                                                    <svg wire:loading.remove.delay="" wire:target=""
                                                                        class="filament-link-icon w-4 h-4 mr-1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        aria-hidden="true">
                                                                        <path ath fill-rule="evenodd"
                                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                            clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" align="center">Data not found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </section>
                    </div>
                </div>

            </div>
            <!-- /.card -->
        </section>
    @endif



@endsection


@section('script')
    <script>
        $('#payment_method').change(function(e) {

            $('.inAccount').addClass('divHide');
            var method = $(this).val();

            if (method == 'Online') {
                console.log(method);
                $('.inAccount').removeClass('divHide');
            }

        });

        $('#payment_method').change();

        function deleteOrder(id) {
            var url = "{{ route('customer.orders.delete', 'ID') }}";
            var newUrl = url.replace('ID', id);

            var custId = $('#customer_id').val();
            var urlCust = "{{ route('customer.order', 'CUSTID') }}";
            var newUrlCust = urlCust.replace('CUSTID', custId);

            if (confirm('Are you sure want to delete')) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response['status']) {
                            window.location.href = newUrlCust;
                        }
                    }
                });
            }
        }

        function deleteOrderItem(id, custId) {
            var url = "{{ route('customer.orders.item.delete', 'ID') }}";
            var newUrl = url.replace('ID', id);

            var urlO = "{{ route('customer.order', 'OID') }}";
            var newUrlO = urlO.replace('OID', custId);

            if (confirm('Are you sure want to delete')) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response['status']) {
                            window.location.href = newUrlO;
                        }
                    }
                });
            }
        }
    </script>
@endsection
