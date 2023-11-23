@extends('layouts.app')
@section('title', 'Print')
@section('orders', 'active')
@section('content')
    <style>
        @media print {
            .h {
                background: #000 !important;
                print-color-adjust: exact;
            }

            .card-body {
                border: 1px solid #000;
                width: 75% !important;
            }
        }
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
                    <div style="display: flex;border:1px solid #000;padding:5px;">
                        <div style="width:70%;text-align:center">
                            <h1 style="margin: 0px">Prabhat Printing Press</h1>
                        </div>
                        <div style="width:30%;text-align:right">
                            <p>Mob. 9084974788<br>
                                Mob. 9528571108
                        </div>
                    </div>
                    <div
                        style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;background: #ccc;color:#000;padding:5px">
                        <h5 style="margin: 0px">Nai Basti, Naugawan Sadat-244251 Distt. Amroha UP India, Cont. 8077955145
                        </h5>
                    </div>
                    <div style="margin-top:5px;margin-bottom:5px">
                        <strong>
                            Order No. :- {{ $order->order_no }}<br>
                            Customer Name:-
                            {{ !empty($order->customer_id) ? getCustomerName($order->customer_id) : $order->customer_name }}
                        </strong>
                    </div>
                    <table style="border:1px solid #000" cellpadding="3" cellspacing='3' border="0" width="700">
                        <thead style="background: #ccc">
                            <tr>
                                <th style="border:1px solid #000;text-align:center">#</th>
                                <th style="border:1px solid #000;text-align:center">Item</th>
                                <th style="border:1px solid #000;text-align:center">Qty</th>
                                <th style="border:1px solid #000;text-align:center">Total</th>
                                <th style="border:1px solid #000;text-align:center">Bal. Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border:1px solid #000">
                                <td></td>
                                <td style="border:1px solid #000;text-align:center">{{ $order->particular }}
                                </td>
                                <td style="border:1px solid #000;text-align:center">{{ $order->qty }}</td>
                                <td style="border:1px solid #000;text-align:center">₹{{ $order->total_amount }}
                                </td>
                                <td style="border:1px solid #000;text-align:center">
                                    ₹{{ $order->total_amount - $order->discount - $advAmt }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mb-3" style="justify-content: center;margin-top:5px">
                        <p>1. आर्डर देने पर 75% अडवांस देना होगा अन्य अपना
                            कार्य अधूरा समझे।<br>
                            2. 15 दिन के बाद तथा बिना पर्ची के सामान नहीं मिलेगा।<br>
                            3. अपना मैटर स्वयं चैक कर लें, गलती होने पर हमारी जिम्मेदारी नहीं होगी।<br>
                            4. आप का कार्य लेट होने पर कोई वाद मान्य नहीं होगा क्योंकि टैक्निकल प्राॅब्लम के चलते
                            ऐसा
                            होना सम्भव है।<br>
                            नोट टैक्स एक्सट्रा होगा। भूलचूक लेनी देनी</p>
                    </div>
                    <button class="no-print btn btn-primary" onclick="window.print();">Print</button>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
