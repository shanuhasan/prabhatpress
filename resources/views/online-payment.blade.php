@extends('layouts.app')
@section('title', 'Online Payments')
@section('report', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Online Payments History</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('report.index') }}" class="btn btn-primary">Report</a>
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
                                    <label for="from_date">Date</label>
                                    <input type="text" name="from_date" class="form-control js-filterdatepicker"
                                        placeholder="Date" value="{{ Request::get('from_date') }}">

                                </div>
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('report.onlinePayment') }}" class="btn btn-danger">Reset</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            @if ($onlineAmount->isNotEmpty())
                                @foreach ($onlineAmount as $item)
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>₹{{ $item->amount }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>{{ getUserName($item->in_account) }}</td>
                                        <td>{{ getUserName($item->updated_by) }}</td>
                                    </tr>
                                    <?php $total += $item->amount; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center">No Advance</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>₹{{ $totalOnlineAmount }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $onlineAmount->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
