@extends('layouts.app')

@section('title', 'Report')
@section('report', 'active')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report</h1>
                </div>
                <div class="col-sm-6">

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
                                    <label for="from_date">From Date</label>
                                    <input type="text" name="from_date" class="form-control js-filterdatepicker"
                                        placeholder="From Date" value="{{ Request::get('from_date') }}">
                                </div>
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('report.index') }}" class="btn btn-danger">Reset</a>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="to_date">To Date</label>
                                    <input type="text" name="to_date" class="form-control js-filterdatepicker"
                                        placeholder="To Date" value="{{ Request::get('to_date') }}">
                                </div>
                            </div>

                        </div>
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
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center">
                            <h3>₹{{ $totalExpenses }}</h3>
                            <h4>Total Expenses</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('expenses.index') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center">
                            <h3>₹{{ $totalAmount }}</h3>
                            <h4>Total Received Amount</h4>
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
                            <h3>₹{{ $totalAmount - $totalExpenses }}</h3>
                            <h4>Total Amount</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

@endsection

@section('script')
@endsection
