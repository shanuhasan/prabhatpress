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
                            <div class="col-md-6">
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

                            <div class="col-md-6">
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
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('expenses.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

@endsection