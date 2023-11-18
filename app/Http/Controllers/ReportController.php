<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Expense;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerPayment;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalReceivedAmount = OrderItem::sum('amount');
        $totalCustomerReceivedAmount = CustomerPayment::sum('amount');
        $totalExpenses = Expense::sum('amount');

        if(!empty($request->get('from_date')) && !empty($request->get('to_date')))
        {
            $totalReceivedAmount = OrderItem::
                                            whereDate('created_at','>=',$request->get('from_date'))
                                            ->whereDate('created_at','<=',$request->get('to_date'))
                                            ->sum('amount');

            $totalCustomerReceivedAmount = CustomerPayment::
                                                        whereDate('created_at','>=',$request->get('from_date'))
                                                        ->whereDate('created_at','<=',$request->get('to_date'))
                                                        ->sum('amount');

            $totalExpenses = Expense::
                                    whereDate('created_at','>=',$request->get('from_date'))
                                    ->whereDate('created_at','<=',$request->get('to_date'))
                                    ->sum('amount');
        }

        if(!empty($request->get('from_date')))
        {
            $totalReceivedAmount = OrderItem::
                                            whereDate('created_at','=',$request->get('from_date'))
                                            ->sum('amount');

            $totalCustomerReceivedAmount = CustomerPayment::
                                                        whereDate('created_at','=',$request->get('from_date'))
                                                        ->sum('amount');

            $totalExpenses = Expense::
                                    whereDate('created_at','=',$request->get('from_date'))
                                    ->sum('amount');
        }

        $totalAmount = $totalReceivedAmount + $totalCustomerReceivedAmount;


        return view('report',[
            'totalAmount'=>$totalAmount,
            'totalExpenses'=>$totalExpenses,
        ]);
    }
}
