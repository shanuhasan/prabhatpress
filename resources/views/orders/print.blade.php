@extends('layouts.app')
@section('title', 'Print')
@section('orders', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Print Order</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h1 style="text-align: center">Rough Estimate</h1>
                    <div class="row">
                        {{-- <div class="col-md-3">
                            <div class="mb-3">
                                <h2>Particular :- {{ $order->particular }}</h2>
                            </div>
                        </div> --}}

                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2>Customer Name :-
                                    {{ !empty($order->customer_id) ? getCustomerName($order->customer_id) : $order->customer_name }}
                                </h2>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2>Order No. :- {{ $order->order_no }}</h2>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2>Quantity:- {{ $order->qty }}</h2r=>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2>Total Amount:- ₹{{ $order->total_amount }}</h2>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2>Bal Amount:- ₹{{ $order->total_amount - $order->discount - $advAmt }}</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <p>Note:- </p>
                            </div>
                        </div>
                    </div>
                    <button class="no-print btn btn-primary" onclick="window.print();">Print</button>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
