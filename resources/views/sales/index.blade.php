@extends('layouts.app')
@section('title', 'Sales')
@section('sales', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sales</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sale.create') }}" class="btn btn-primary">Add Sale</a>
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
                                    <label for="date">Date</label>
                                    <input type="text" name="date" class="form-control js-filterdatepicker"
                                        placeholder="Date" value="{{ Request::get('date') }}">
                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="year">Year</label>
                                    <select name="year" class="form-control">
                                        <option value="">Select Year</option>
                                        @foreach (years() as $year)
                                            <option
                                                {{ (empty(Request::get('year')) ? date('Y') : Request::get('year') == $year) ? 'selected' : '' }}
                                                value={{ $year }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('sale.index') }}" class="btn btn-danger">Reset</a>
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
                                <th>Date</th>
                                <th>Particular</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Account</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($sales->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($sales as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            {{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->particular }}</td>
                                        <td>₹{{ $item->amount }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>{{ getUserName($item->in_account) }}</td>
                                        <td>
                                            <a href="{{ route('sale.edit', $item->id) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="javascript:void()" onclick="deleteSale({{ $item->id }})"
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
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>₹{{ $totalSalesAmount }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $sales->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function deleteSale(id) {
            var url = "{{ route('sale.delete', 'ID') }}";
            var newUrl = url.replace('ID', id);

            if (confirm('Are you sure want to delete?')) {
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
                            window.location.href = "{{ route('sale.index') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection
