@extends('layouts.app')
@section('title', 'Edit Order')
@section('orders', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Order</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">New Order</a>
                    <a href="{{ route('orders.index') }}" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col-md-8">
                <div class="container-fluid">
                    <form action="{{ route('orders.update', $order->id) }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="order_no">Order No.*</label>
                                            <input type="text" readonly name="order_no"
                                                class="form-control @error('order_no') is-invalid	@enderror"
                                                placeholder="Order No." value="{{ $order->order_no }}">
                                            @error('order_no')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="customer_name">Name*</label>
                                            <input type="text" name="customer_name"
                                                class="form-control @error('customer_name') is-invalid	@enderror"
                                                placeholder="Customer Name" value="{{ $order->customer_name }}">
                                            @error('customer_name')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="phone">Phone*</label>
                                            <input type="text" name="phone"
                                                class="form-control @error('phone') is-invalid	@enderror"
                                                placeholder="Phone" value="{{ $order->phone }}">
                                            @error('phone')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="phone">Address</label>
                                            <textarea name="address" id="address" class="form-control" cols="30" rows="5">{!! $order->address !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="particular">Particular*</label>
                                            <input type="text" name="particular"
                                                class="form-control @error('particular') is-invalid	@enderror"
                                                placeholder="Particular" value="{{ $order->particular }}">
                                            @error('particular')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="qty">Qty</label>
                                            <input type="number" name="qty"
                                                class="form-control qty @error('qty') is-invalid	@enderror"
                                                placeholder="Qty" value="{{ $order->qty }}">
                                            @error('qty')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="total_amount">Total Amount*</label>
                                            <input type="number" name="total_amount"
                                                class="form-control total_amount @error('total_amount') is-invalid	@enderror"
                                                placeholder="Total Amount" value="{{ $order->total_amount }}">
                                            @error('total_amount')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="total_amount">Advance Amount</label>
                                            <input type="number" name="advance_amount"
                                                class="form-control advance_amount @error('advance_amount') is-invalid	@enderror"
                                                placeholder="Advance Amount">
                                            @error('advance_amount')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status">Status*</label>
                                            <select name="status"
                                                class="form-control @error('particular') is-invalid	@enderror">
                                                <option {{ $order->status == 'Pending' ? 'selected' : '' }}
                                                    value="Pending">Pending
                                                </option>
                                                <option {{ $order->status == 'Complete' ? 'selected' : '' }}
                                                    value="Complete">
                                                    Complete</option>
                                            </select>
                                            @error('status')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($orderDetail))
                                            <?php $total = 0; ?>
                                            @foreach ($orderDetail as $item)
                                                <tr>
                                                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                    <td>₹{{ $item->amount }}</td>
                                                </tr>
                                                <?php $total += $item->amount; ?>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2">No Advance</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Total Amount</th>
                                            <th>₹{{ $total }}</th>
                                        </tr>
                                        <tr>
                                            <th>Balance Amount</th>
                                            <th>₹{{ $order->total_amount - $total }}</th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
            </div>
        </div>

        <!-- /.card -->
    </section>
    <!-- /.content -->


@endsection
@section('script')
    {{-- <script>
        $('.total_amount,.advance_amount').change(function(e) {
            e.preventDefault();
            var totalAmt = $('.total_amount').val();
            var advanceAmt = $('.advance_amount').val();

            $('.balance_amount').val(totalAmt - advanceAmt);

        });

        $('.total_amount,.advance_amount').change();
    </script> --}}
@endsection
