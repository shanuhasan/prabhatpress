@extends('layouts.app')
@section('title', 'Supplier Items')
@section('supplier', 'active')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Suppliers Items ({{ $supplier->name }}, {{ $supplier->phone }})
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('supplier.item.create', $supplier->guid) }}" class="btn btn-primary">Add</a>
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
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="{{ route('supplier.item', $supplier->guid) }}" class="btn btn-danger">Reset</a>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword"
                                    class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Particular</th>
                                <th>Pcs/Qty</th>
                                <th>Size</th>
                                <th>Sq. Fit</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($items->isNotEmpty())
                                <?php $i = 1; ?>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->particular }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->size_1 }}X{{ $item->size_2 }}</td>
                                        <td>{{ $item->size_1 }}</td>
                                        <td>₹{{ $item->rate }}</td>
                                        <td>₹{{ $item->amount }}</td>
                                        <td>
                                            <a
                                                href="{{ route('supplier.item.edit', ['guid' => $supplier->guid, 'itemGuid' => $item->guid]) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="javascript:void()"
                                                onclick="deleteItem('{{ $item->guid }}','{{ $supplier->guid }}')"
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
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    {{-- @if ($items->isNotEmpty())
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('supplier.orders.payment') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $customerId }}" name="customer_id" id="customer_id">
                            <div class="card">
                                <div class="card-body">
                                    <span style="font-size: 24px;">
                                        Total Amount :-
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>₹{{ $totalAmount }}</strong><br>
                                        Discount :-
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>₹{{ $totalDiscount + $customerTotalDiscount }}</strong><br>
                                        Received Amount :-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>₹{{ $customerTotalPayment }}</strong><br>
                                        Remaining Balance :-&nbsp;&nbsp;
                                        <strong>₹{{ $totalAmount - $totalDiscount - $customerTotalPayment - $customerTotalDiscount }}</strong>
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="order_no">Amount</label>
                                                <input type="text" name="amount"
                                                    class="form-control only-number @error('amount') is-invalid	@enderror"
                                                    placeholder="Amount">
                                                @error('amount')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="payment_method">Payment Method<span
                                                        style="color: red">*</span></label>
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
                                                <label for="order_no">Discount</label>
                                                <input type="text" name="discount"
                                                    class="form-control only-number @error('discount') is-invalid	@enderror"
                                                    placeholder="Discount">
                                                @error('discount')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
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
                                                    <th>Discount</th>
                                                    <th>Payment Method</th>
                                                    <th>Account</th>
                                                    <th>Received By</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($customerPayment->isNotEmpty())
                                                    @foreach ($customerPayment as $item)
                                                        <tr>
                                                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                            <td>{{ !empty($item->amount) ? '₹' . $item->amount : '' }}
                                                            <td>{{ !empty($item->discount) ? '₹' . $item->discount : '' }}
                                                            </td>
                                                            <td>{{ $item->payment_method }}</td>
                                                            <td>{{ getUserName($item->in_account) }}</td>
                                                            <td>{{ getUserName($item->updated_by) }}</td>
                                                            <td>
                                                                <a href="javascript:void()"
                                                                    onclick="deleteOrderItem({{ $item->id }},{{ $customerId }})"
                                                                    class="text-danger w-4 h-4 mr-1">
                                                                    <svg wire:loading.remove.delay="" wire:target=""
                                                                        class="filament-link-icon w-4 h-4 mr-1"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        aria-hidden="true">
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
                                                        <td colspan="5" align="center">Data not found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </section>
                    </div>
                </div>

            </div>
            <!-- /.card -->
        </section>
    @endif --}}



@endsection


@section('script')
    <script>
        function deleteItem(guid, supplierGuid) {
            var url = "{{ route('supplier.item.delete', 'GUID') }}";
            var newUrl = url.replace('GUID', guid);

            var urlO = "{{ route('supplier.item', 'OID') }}";
            var newUrlO = urlO.replace('OID', supplierGuid);

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
    </script>
@endsection
