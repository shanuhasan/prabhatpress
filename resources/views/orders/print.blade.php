@extends('layouts.app')
@section('title', 'Print')
@section('orders', 'active')
@section('content')
    <style>

    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Print Order</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h1 style="text-align: center">Rough Estimate</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <strong>
                                    Customer Name:-
                                    {{ !empty($order->customer_id) ? getCustomerName($order->customer_id) : $order->customer_name }}<br>
                                    Order No. :- {{ $order->order_no }}</br>
                                </strong>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <table style="border:1px solid #ccc" cellpadding="3" cellspacing='3' border="0"
                                    width="700">
                                    <thead style="background: #ccc">
                                        <tr>
                                            <th style="border:1px solid #ccc;text-align:center">#</th>
                                            <th style="border:1px solid #ccc;text-align:center">Item</th>
                                            <th style="border:1px solid #ccc;text-align:center">Qty</th>
                                            <th style="border:1px solid #ccc;text-align:center">Total</th>
                                            <th style="border:1px solid #ccc;text-align:center">Bal. Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border:1px solid #ccc">
                                            <td></td>
                                            <td style="border:1px solid #ccc;text-align:center">{{ $order->particular }}
                                            </td>
                                            <td style="border:1px solid #ccc;text-align:center">{{ $order->qty }}</td>
                                            <td style="border:1px solid #ccc;text-align:center">₹{{ $order->total_amount }}
                                            </td>
                                            <td style="border:1px solid #ccc;text-align:center">
                                                ₹{{ $order->total_amount - $order->discount - $advAmt }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3" style="justify-content: center;">
                                <p>1. आर्डर देने पर 75% अडवांस देना होगा अन्य अपना
                                    कार्य अधूरा समझे।<br>
                                    2. 15 दिन के बाद तथा बिना पर्ची के सामान नहीं मिलेगा।<br>
                                    3. अपना मैटर स्वयं चैक कर लें, गलती होने पर हमारी जिम्मेदारी नहीं होगी।<br>
                                    4. आप का कार्य लेट होने पर कोई वाद मान्य नहीं होगा क्योंकि टैक्निकल प्राॅब्लम के चलते
                                    ऐसा
                                    होना सम्भव है।<br>
                                    नोट टैक्स एक्सट्रा होगा। भूलचूक लेनी देनी</p>
                            </div>
                        </div>
                    </div>
                    <button class="no-print btn btn-primary" onclick="window.print();">Print</button>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
