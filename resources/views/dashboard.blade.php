@extends('layouts.app')

@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background: blue;color:#fff;text-align:center">
                            <h3>{{ $totalOrder }}</h3>
                            <h4>Total Orders</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background: red;color:#fff;text-align:center">
                            <h3>{{ $totalOrderPending }}</h3>
                            <h4>Pending Orders</h4>
                        </div>
                        <a href="{{ route('orders.pending') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background: orange;color:#fff;text-align:center">
                            <h3>{{ $totalOrderComplete }}</h3>
                            <h4>Complete Orders</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('orders.complete') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background: green;color:#fff;text-align:center">
                            <h3>{{ $totalOrderDelivered }}</h3>
                            <h4>Delivered Orders</h4>
                        </div>
                        <a href="{{ route('orders.delivered') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center">
                            <h3>₹{{ $totalReceivedAmount }}</h3>
                            <h4>Total Received</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center">
                            <h3>{{ $todayOrder }}</h3>
                            <h4>Today Orders</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center">
                            <h3>₹{{ $todayOrderAmount }}</h3>
                            <h4>Today Order Amount</h4>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-6"></div>

                {{-- today amount --}}

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background:green;text-align:center;color:#ffffff">
                            <h3>₹{{ $todayReceivedAmount }}</h3>
                            <h4><strong>Today Received</strong></h4>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background:red;text-align:center;color:#ffffff">
                            <h3>₹{{ $todayExpenses }}</h3>
                            <h4><strong>Today Expense</strong></h4>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner blink-text-success" style="text-align:center">
                            <h3>₹{{ $todayReceivedAmount - $todayExpenses }}</h3>
                            <h4><strong>Today Collection</strong></h4>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-6"></div>

                @if (!empty($todayOnlineAmount))
                    @foreach ($todayOnlineAmount as $item)
                        <div class="col-lg-4 col-6">
                            <div class="small-box card">
                                <div class="inner" style="text-align:center">
                                    <h3>₹{{ $item['amount'] }}</h3>
                                    <h4>Today Online Amount ({{ getUserName($item['in_account']) }})</h4>
                                </div>
                                <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>₹{{ $totalOrderAmount }}</h3>
                            <p>Total Order Amount</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>₹{{ $totalOrderAmountCurrentMonth }}</h3>
                            <p>Total Order Amount This Month</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>₹{{ $totalOrderAmountLastMonth }}</h3>
                            <p>Total Order Amount Last Month ({{ $lastMonth }})</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>₹{{ $totalOrderAmountLastThirtyDays }}</h3>
                            <p>Total Order Amount Last 30 Days</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                    </div>
                </div> --}}

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

@endsection

@section('script')
@endsection
