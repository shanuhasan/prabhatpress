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
                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $totalOrder }}</h3>
                            <b>Total Orders</b>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $totalOrderPending }}</h3>
                            <b>Pending Orders</b>
                        </div>
                        <a href="{{ route('orders.pending') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $totalOrderComplete }}</h3>
                            <b>Complete Orders</b>
                        </div>
                        <a href="{{ route('orders.complete') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>₹{{ $todayOrderAmount }}</h3>
                            <b>Today Order Amount</b>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>₹{{ $todayReceivedAmount }}</h3>
                            <b>Today Received Amount</b>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

                @if ($todayOnlineAmount->isNotEmpty())
                    @foreach ($todayOnlineAmount as $item)
                        <div class="col-lg-4 col-6">
                            <div class="small-box card">
                                <div class="inner">
                                    <h3>₹{{ !empty($item->amount) ? $item->amount : 0 }}</h3>
                                    <b>Today Received Online Amount ({{ getUserName($item->in_account) }})</b>
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
                            <h3>₹{{ $totalReceivedAmount }}</h3>
                            <p>Total Received Amount</p>
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
