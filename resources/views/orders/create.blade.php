<?php
use App\Models\Order;
?>
@extends('layouts.app')
@section('title', 'New Order')
@section('orders', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Order</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Orders</a>
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
            <form action="{{ route('orders.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="order_no">Order No.*</label>
                                    <input type="text" name="order_no"
                                        class="form-control text-to-upper @error('order_no') is-invalid	@enderror"
                                        placeholder="Order No.">
                                    @error('order_no')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="customer_name">Name*</label>
                                    <input type="text" name="customer_name"
                                        class="form-control text-to-upper @error('customer_name') is-invalid	@enderror"
                                        placeholder="Customer Name">
                                    @error('customer_name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone"
                                        class="form-control only-number @error('phone') is-invalid	@enderror"
                                        placeholder="Phone">
                                    @error('phone')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="phone">Address</label>
                                    <textarea name="address" id="address" class="form-control text-to-upper" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="particular">Particular*</label>
                                    <input type="text" name="particular"
                                        class="form-control text-to-upper @error('particular') is-invalid	@enderror"
                                        placeholder="Particular">
                                    @error('particular')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty">Qty</label>
                                    <input type="number" name="qty"
                                        class="form-control qty @error('qty') is-invalid	@enderror" placeholder="Qty">
                                    @error('qty')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_amount">Total Amount*</label>
                                    <input type="number" name="total_amount"
                                        class="form-control total_amount @error('total_amount') is-invalid	@enderror"
                                        placeholder="Total Amount">
                                    @error('total_amount')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="discount">Discount</label>
                                    <input type="number" name="discount"
                                        class="form-control discount @error('discount') is-invalid	@enderror"
                                        placeholder="Discount">
                                    @error('discount')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
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
                                        class="form-control js-datepicker" placeholder="Delivery At">
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
                                    <select name="status" class="form-control @error('status') is-invalid	@enderror">
                                        @foreach (statusList() as $key => $item)
                                            <option value={{ $key }}>{{ $item }}</option>
                                        @endforeach
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
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
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
@endsection
