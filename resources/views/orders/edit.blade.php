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
        <div class="container-fluid">
            @include('message')
            <form action="{{ route('orders.update', $order->id) }}" method="post">
                @csrf
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
                                        class="form-control @error('phone') is-invalid	@enderror" placeholder="Phone"
                                        value="{{ $order->phone }}">
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
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status">Status*</label>
                                    <select name="status" class="form-control @error('particular') is-invalid	@enderror">
                                        <option {{ $order->status == 'Pending' ? 'selected' : '' }} value="Pending">
                                            Pending
                                        </option>
                                        <option {{ $order->status == 'Completed' ? 'selected' : '' }} value="Completed">
                                            Completed</option>
                                        <option {{ $order->status == 'Delivered' ? 'selected' : '' }} value="Delivered">
                                            Delivered</option>
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
        <!-- /.card -->
    </section>
    <!-- /.content -->

    <section class="content-header">
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
                                <th></th>
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
                                        <td>
                                            <a href="javascript:void()"
                                                onclick="deleteOrderItem({{ $item->id }},{{ $order->id }})"
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
                                    <?php $total += $item->amount; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center">No Advance</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Total Received Amount</th>
                                <th colspan="5">₹{{ $total }}</th>

                            </tr>
                            <tr>
                                <th>Balance Amount</th>
                                <th colspan="5">₹{{ $order->total_amount - $total }}</th>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

    <br>


@endsection
@section('script')
    <script>
        function deleteOrderItem(id, orderId) {
            var url = "{{ route('orders.item.delete', 'ID') }}";
            var newUrl = url.replace('ID', id);

            var urlO = "{{ route('orders.edit', 'OID') }}";
            var newUrlO = urlO.replace('OID', orderId);

            if (confirm('Are you sure want to delete')) {
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
                            window.location.href = newUrlO;
                        }
                    }
                });
            }
        }

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
@endsection
