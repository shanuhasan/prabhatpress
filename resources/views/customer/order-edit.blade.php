@extends('layouts.app')
@section('title', 'Edit Order')
@section('customers', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Order</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('customer.index') }}" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('customer.orders.update', $order->id) }}" method="post">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customerId }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="order_no">Order No.*</label>
                                    <input type="text" readonly name="order_no"
                                        class="form-control @error('order_no') is-invalid	@enderror" placeholder="Order No."
                                        value="{{ $order->order_no }}">
                                    @error('order_no')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="qty">Qty</label>
                                    <input type="number" name="qty"
                                        class="form-control qty @error('qty') is-invalid	@enderror" placeholder="Qty"
                                        value="{{ $order->qty }}">
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="delivery_at">Delivery At</label>
                                    <input type="text" name="delivery_at" id="delivery_at"
                                        class="form-control js-datepicker" placeholder="Delivery At"
                                        value="{{ $order->delivery_at }}">
                                    @error('delivery_at')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="payment_method">Payment Method*</label>
                                    <select name="payment_method"
                                        class="form-control @error('payment_method') is-invalid	@enderror"
                                        id="payment_method">
                                        <option value="Cash">Cash</option>
                                        <option value="Online">Online</option>
                                    </select>
                                    @error('payment_method')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 divHide inAccount">
                                <div class="mb-3">
                                    <label for="in_account">Account*</label>
                                    <select name="in_account"
                                        class="form-control @error('in_account') is-invalid	@enderror">
                                        @foreach (getUsers() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('in_account')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status">Status*</label>
                                    <select name="status" class="form-control @error('particular') is-invalid	@enderror">
                                        <option {{ $order->status == 'Pending' ? 'selected' : '' }} value="Pending">
                                            Pending
                                        </option>
                                        <option {{ $order->status == 'Complete' ? 'selected' : '' }} value="Complete">
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
                    <a href="{{ route('customer.order', $customerId) }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    {{-- <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment History</h1>
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
                                <th>Date</th>
                                <th>Received Amount</th>
                                <th>Payment Method</th>
                                <th>Account</th>
                                <th>Received By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            @if ($orderDetail->isNotEmpty())
                                @foreach ($orderDetail as $item)
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
                                    <td colspan="2" align="center">No Advance</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Total Received Amount</th>
                                <th colspan="4">₹{{ $total }}</th>

                            </tr>
                            <tr>
                                <th>Balance Amount</th>
                                <th colspan="4">₹{{ $order->total_amount - $total }}</th>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

    <br> --}}


@endsection
{{-- @section('script')
    <script>
        $('#payment_method').change(function(e) {
            $('.inAccount').addClass('divHide');
            var method = $(this).val();
            if (method == 'Online') {
                console.log(method);
                $('.inAccount').removeClass('divHide');
            }
        });

        $('#payment_method').change();
    </script>
@endsection --}}
