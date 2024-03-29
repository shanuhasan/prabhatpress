@extends('layouts.app')
@section('title', 'Orders')
@section('orders', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Delivered Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">New Order</a>
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
                                <th width="60">S No.</th>
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
                                    $days = '';
                                    if (!empty($order->delivery_at)) {
                                        $days = numberOfDays(date('Y-m-d'), date($order->delivery_at));
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><a href="{{ route('orders.edit', $order->id) }}">{{ $order->order_no }}</a></td>
                                        <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                        <td
                                            class="{{ !empty($order->delivery_at) && $order->status == 'Pending' && $days <= +2 ? 'blink-text' : '' }}">
                                            {{ !empty($order->delivery_at) ? date('d-m-Y', strtotime($order->delivery_at)) : '' }}
                                        </td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td><a href="{{ route('orders.edit', $order->id) }}">{{ $order->particular }}</a>
                                        <td>{{ $order->qty }}</td>
                                        <td>₹{{ $order->total_amount }}</td>
                                        <td>₹{{ $order->discount }}</td>
                                        <td
                                            style="{{ $order->status == 'Delivered' && $order->total_amount - $advAmt > 0 ? 'background:red;color:#fff;font-weight:bold;' : '' }}">
                                            ₹{{ $order->total_amount - $order->discount - $advAmt }}</td>
                                        <td style="{{ statusColor($order->status) }}">
                                            {{ $order->status }}</td>
                                        <td>
                                            <a href="{{ route('orders.edit', $order->id) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Record Not Found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
