@extends('layouts.app')
@section('title', 'Orders')
@section('orders', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">New Order</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form action="" method="get">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="search">Search</label>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Name/Particular/Phone/Order No." value="{{ Request::get('search') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach (statusList() as $key => $item)
                                            <option {{ Request::get('status') == statusList()[$key] ? 'selected' : '' }}
                                                value={{ $key }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="pending-amount">Order Amount Pending</label>
                                    <select name="pending-amount" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="2"
                                            {{ Request::get('pending-amount') == '2' ? 'selected' : '' }}>Pending Amount
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('message')
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Date</th>
                                <th>Delivery At</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Particular</th>
                                <th>Qty</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Balance Amount</th>
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
                                    
                                    // date diff in days
                                    $days = '';
                                    if (!empty($order->delivery_at)) {
                                        $days = numberOfDays(date('Y-m-d'), date($order->delivery_at));
                                    }
                                    
                                    //total Amount after discount
                                    $totalAmountAfterDiscount = $order->total_amount - $order->discount;
                                    
                                    ?>
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if (!empty($order->customer_id))
                                                <a
                                                    href="{{ route('customer.order', $order->customer_id) }}">{{ $order->order_no }}</a>
                                            @else
                                                <a
                                                    href="{{ route('orders.edit', $order->id) }}">{{ $order->order_no }}</a>
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                        <td
                                            class="{{ !empty($order->delivery_at) && $order->status == 'Pending' && $days <= +2 ? 'blink-text' : '' }}">
                                            {{ !empty($order->delivery_at) ? date('d-m-Y', strtotime($order->delivery_at)) : '' }}
                                        </td>
                                        <td>{{ !empty($order->customer_id) ? getCustomerName($order->customer_id) : $order->customer_name }}
                                        </td>
                                        <td>{{ !empty($order->customer_id) ? getCustomerPhone($order->customer_id) : $order->phone }}
                                        </td>
                                        <td>
                                            @if (!empty($order->customer_id))
                                                <a
                                                    href="{{ route('customer.order', $order->customer_id) }}">{{ $order->particular }}</a>
                                            @else
                                                <a
                                                    href="{{ route('orders.edit', $order->id) }}">{{ $order->particular }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $order->qty }}</td>
                                        <td>₹{{ $order->total_amount }}</td>
                                        <td>{{ !empty($order->discount) ? '₹' . $order->discount : '' }}</td>
                                        @if (!empty($order->customer_id))
                                            <td></td>
                                        @else
                                            <td
                                                style="{{ $order->status == 'Delivered' && $totalAmountAfterDiscount - $advAmt > 0 ? 'background:red;color:#fff;font-weight:bold;' : '' }}">
                                                ₹{{ $totalAmountAfterDiscount - $advAmt }}</td>
                                        @endif

                                        <td>{{ getUserName($order->created_by) }}</td>
                                        <td style="{{ statusColor($order->status) }}">
                                            {{ $order->status }}</td>
                                        <td>
                                            @if (!empty($order->customer_id))
                                                <a href="{{ route('customer.order', $order->customer_id) }}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="{{ route('orders.edit', $order->id) }}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif

                                            {{-- <a href="javascript:void()" onclick="deleteOrder({{ $order->id }})"
                                                class="text-danger w-4 h-4 mr-1">
                                                <svg wire:loading.remove.delay="" wire:target=""
                                                    class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path ath fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </a> --}}

                                            <a href="{{ route('orders.print', $order->id) }}">
                                                <i class="fa fa-print" aria-hidden="true"></i>
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
                    {{-- {{ $orders->links('pagination::bootstrap-5') }} --}}
                    {!! $orders->appends(request()->input())->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function deleteOrder(id) {
            var url = "{{ route('orders.delete', 'ID') }}";
            var newUrl = url.replace('ID', id);

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
                            window.location.href = "{{ route('orders.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
