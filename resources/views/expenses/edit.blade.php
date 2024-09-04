<?php
use App\Models\Expense;
?>
@extends('layouts.app')
@section('title', 'Edit Expense')
@section('expenses', 'active')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Expense</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('expenses.index') }}" class="btn btn-info">Back</a>
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
            <form action="{{ route('expenses.update', $expense->id) }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="particular">Particular*</label>
                                    <input type="text" name="particular"
                                        class="form-control @error('particular') is-invalid	@enderror"
                                        placeholder="Particular" value="{{ $expense->particular }}">
                                    @error('particular')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="type">Type*</label>
                                    <select name="type" class="form-control @error('type') is-invalid	@enderror">
                                        @foreach (Expense::getExpenseList() as $key => $item)
                                            <option {{ $expense->type == $key ? 'selected' : '' }}
                                                value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="payment_method">Payment Method*</label>
                                    <select name="payment_method"
                                        class="form-control @error('payment_method') is-invalid	@enderror"
                                        id="payment_method">
                                        <option {{ $expense->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">
                                            Cash
                                        </option>
                                        <option {{ $expense->payment_method == 'Online' ? 'selected' : '' }} value="Online">
                                            Online
                                        </option>
                                    </select>
                                    @error('payment_method')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 divHide inAccount">
                                <div class="mb-3">
                                    <label for="from_account">Account*</label>
                                    <select name="from_account"
                                        class="form-control @error('from_account') is-invalid	@enderror">
                                        @foreach (getUsers() as $user)
                                            <option {{ $expense->from_account == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('from_account')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="amount">Amount*</label>
                                    <input type="number" name="amount"
                                        class="form-control amount @error('amount') is-invalid	@enderror"
                                        placeholder="Total Amount" value="{{ $expense->amount }}">
                                    @error('amount')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-info">Cancel</a>
                    </div>
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
