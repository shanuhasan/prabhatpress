@extends('layouts.app')
@section('title', 'New Item')
@section('supplier', 'active')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Item ({{ $supplier->name }} , {{ $supplier->phone }})</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('supplier.item', $supplier->guid) }}" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('supplier.item.store') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $supplier->guid }}" name="guid">
                <input type="hidden" value="{{ $supplier->id }}" name="supplier_id">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type">Type<span style="color: red">*</span></label>
                                    <select name="type" class="form-control @error('type') is-invalid	@enderror">
                                        <option value="">Select Type</option>
                                        @foreach (type() as $key => $item)
                                            <option value={{ $key }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="particular">Particular<span style="color: red">*</span></label>
                                    <input type="text" name="particular"
                                        class="form-control @error('particular') is-invalid	@enderror"
                                        placeholder="Particular">
                                    @error('particular')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="qty">Pcs/Qty<span style="color: red">*</span></label>
                                    <input type="number" name="qty" value="1"
                                        class="form-control qty @error('qty') is-invalid @enderror" placeholder="Pcs/Qty">
                                    @error('qty')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="size_1">Size<span style="color: red">*</span></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="number" name="size_1"
                                                class="form-control size_1 @error('size_1') is-invalid	@enderror"
                                                placeholder="Size">
                                            @error('size_1')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <b style="padding-top: 7px">X</b>
                                        <div class="col-md-4">
                                            <input type="number" name="size_2"
                                                class="form-control size_2 @error('size_2') is-invalid	@enderror"
                                                placeholder="Size">
                                            @error('size_2')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="size_3">Sq. Fit<span style="color: red">*</span></label>
                                    <input type="number" name="size_3" readonly
                                        class="form-control size_3 @error('size_3') is-invalid	@enderror"
                                        placeholder="Sq. Fit">
                                    @error('size_3')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rate">Rate<span style="color: red">*</span></label>
                                    <input type="number" name="rate"
                                        class="form-control rate @error('rate') is-invalid	@enderror" placeholder="Rate">
                                    @error('rate')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="amount">Amount<span style="color: red">*</span></label>
                                    <input type="number" name="amount" readonly
                                        class="form-control amount @error('amount') is-invalid	@enderror"
                                        placeholder="Amount">
                                    @error('amount')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-success">Create</button>
                            <a href="{{ route('supplier.item', $supplier->id) }}" class="btn btn-info">Cancel</a>
                        </div>
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
        $('.size_1,.size_2').change(function(e) {
            var size_1 = $(".size_1").val();
            var size_2 = $(".size_2").val();

            if (size_1 != '' && size_2 != "") {
                $(".size_3").val(size_1 * size_2);
            } else {
                $(".size_3").val(0);
            }

            $('.rate').change();
        });

        $('.size_1,.size_2').change();

        $('.rate').change(function(e) {
            var rate = $(this).val();
            var sqFit = $(".size_3").val();
            var qty = $(".qty").val();

            if (sqFit != '' && rate != '' && qty) {
                $(".amount").val(rate * sqFit * qty);
            } else {
                $(".amount").val(0);
            }
        });

        $('.rate').change();

        $('.qty').change(function(e) {
            var qty = $(this).val();
            var sqFit = $(".size_3").val();
            var rate = $(".rate").val();

            if (sqFit != '' && rate != '' && qty) {
                $(".amount").val(rate * sqFit * qty);
            } else {
                $(".amount").val(0);
            }
        });

        $('.qty').change();
    </script>
@endsection
