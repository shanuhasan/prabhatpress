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

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background:green;color:#ffffff">
                            <h4><strong>Total Received</strong></h4>
                            <h5>Cash : - ₹{{ $totalCashAmount }}</h5>
                            @if (!empty($totalOnlineAmount))
                                @foreach ($totalOnlineAmount as $item)
                                    <h5>Online ({{ getUserName($item['in_account']) }}):- ₹{{ $item['amount'] }}</h5>
                                @endforeach
                            @endif
                            <h4>Total : - ₹{{ $totalAmount }}</h3>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background:red;color:#ffffff">
                            <h4><strong>Total Expenses</strong></h4>
                            <h5>Cash : - ₹{{ $totalCashExpenses }}</h5>
                            @if (!empty($totalOnlineExpenses))
                                @foreach ($totalOnlineExpenses as $item)
                                    <h5>Online ({{ getUserName($item['from_account']) }}):- ₹{{ $item['amount'] }}</h5>
                                @endforeach
                            @endif
                            <h4>Total : - ₹{{ $totalExpenses }}</h3>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>
                <div class="col-lg-4 col-6"></div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center;background:green;color:#ffffff">
                            <h4>Total Online Collection</h4>
                            <h3>₹{{ $onlyTotalOnlineAmount }}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('report.onlinePayment') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner blink-text-success" style="text-align:center">
                            <h4>Total Collection</h4>
                            <h3>₹{{ $totalAmount - $totalExpenses }}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div>

                {{-- <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="text-align:center">
                            <h3>₹{{ $totalAmount }}</h3>
                            <h5>Total Received Amount</h5>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                    </div>
                </div> --}}

                {{-- @if (!empty($totalOnlineAmount))
                    @foreach ($totalOnlineAmount as $item)
                        <div class="col-lg-3 col-6">
                            <div class="small-box card">
                                <div class="inner" style="text-align:center">
                                    <h3>₹{{ $item['amount'] }}</h3>
                                    <h5>Online Collection ({{ getUserName($item['in_account']) }})</h5>
                                </div>
                                <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                            </div>
                        </div>
                    @endforeach
                @endif --}}

                {{-- <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner" style="background:red;text-align:center;color:#ffffff">
                            <h3>₹{{ $totalExpenses }}</h3>
                            <h5>Total Expenses</h5>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('expenses.index') }}" class="small-box-footer text-dark">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}


                {{-- 
                @if (!empty($totalOnlineExpenses))
                    @foreach ($totalOnlineExpenses as $item)
                        <div class="col-lg-3 col-6">
                            <div class="small-box card">
                                <div class="inner" style="text-align:center">
                                    <h3>₹{{ $item['amount'] }}</h3>
                                    <h5>Online Expenses ({{ getUserName($item['from_account']) }})</h5>
                                </div>
                                <a href="javascript:void(0);" class="small-box-footer text-dark">&nbsp;</a>
                            </div>
                        </div>
                    @endforeach
                @endif --}}

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Collection History</h1>
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
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Received Amount</th>
                                <th>Payment Method</th>
                                <th>Account</th>
                                <th>Received By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($totalOrderItem->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($totalOrderItem as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ !empty($item->customer_id) ? getCustomerName($item->customer_id) . ' (' . getCustomerCompany($item->customer_id) . ')' : getCustomerNameFromOrder($item->order_id) }}
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>₹{{ $item->amount }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>{{ getUserName($item->in_account) }}</td>
                                        <td>{{ getUserName($item->updated_by) }}</td>
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
                <div class="card-footer clearfix">
                    {{ $totalOrderItem->appends(['from_date' => $from_date, 'to_date' => $to_date])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script')
@endsection
