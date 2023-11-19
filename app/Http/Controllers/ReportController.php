<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Expense;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalReceivedAmount = OrderItem::sum('amount');        
       
        $totalOrderItem = OrderItem::orderBy('id','DESC');

        // total online received amount with account name
        $totalOnlineAmount = OrderItem::select('in_account', DB::raw('SUM(amount) as amount'))
                                        ->where('payment_method','Online')
                                        ->groupBy('in_account')->get()->toArray();
            
        $totalCashAmount = OrderItem::where('payment_method','Cash')
                                            ->sum('amount');
        //end total online received amount with account name

        // total expenses amount
        $totalExpenses = Expense::sum('amount');
        $totalOnlineExpenses = Expense::select('from_account', DB::raw('SUM(amount) as amount'))
                                        ->where('payment_method','Online')
                                        ->groupBy('from_account')->get()->toArray();
        $totalCashExpenses = Expense::where('payment_method','Cash')
                                            ->sum('amount');
        //end total expenses amount

        if(!empty($request->get('from_date')))
        {

            $totalOrderItem = OrderItem::whereDate('created_at','=',$request->get('from_date'));

            $totalReceivedAmount = OrderItem::whereDate('created_at','=',$request->get('from_date'))
                                            ->sum('amount');
            $totalCashAmount     = OrderItem::where('payment_method','Cash')
                                            ->whereDate('created_at','=',$request->get('from_date'))
                                            ->sum('amount');
            $totalOnlineAmount   = OrderItem::select('in_account', DB::raw('SUM(amount) as amount'))
                                            ->where('payment_method','Online')
                                            ->whereDate('created_at','=',$request->get('from_date'))
                                            ->groupBy('in_account')->get()->toArray();

            $totalExpenses       = Expense::whereDate('created_at','=',$request->get('from_date'))
                                            ->sum('amount');

            $totalCashExpenses   = Expense::where('payment_method','Cash')
                                            ->whereDate('created_at','=',$request->get('from_date'))
                                            ->sum('amount');
            
            $totalOnlineExpenses = Expense::select('from_account', DB::raw('SUM(amount) as amount'))
                                            ->where('payment_method','Online')
                                            ->whereDate('created_at','=',$request->get('from_date'))
                                            ->groupBy('from_account')->get()->toArray();
        }

        if(!empty($request->get('from_date')) && !empty($request->get('to_date')))
        {
            $totalOrderItem = OrderItem::whereDate('created_at','>=',$request->get('from_date'))
                                    ->whereDate('created_at','<=',$request->get('to_date'));

            $totalReceivedAmount = OrderItem::whereDate('created_at','>=',$request->get('from_date'))
                                            ->whereDate('created_at','<=',$request->get('to_date'))
                                            ->sum('amount');
            $totalCashAmount     = OrderItem::where('payment_method','Cash')
                                            ->whereDate('created_at','>=',$request->get('from_date'))
                                            ->whereDate('created_at','<=',$request->get('to_date'))
                                            ->sum('amount');
            $totalOnlineAmount   = OrderItem::select('in_account', DB::raw('SUM(amount) as amount'))
                                            ->where('payment_method','Online')
                                            ->whereDate('created_at','>=',$request->get('from_date'))
                                            ->whereDate('created_at','<=',$request->get('to_date'))
                                            ->groupBy('in_account')->get()->toArray();

            $totalExpenses       = Expense::whereDate('created_at','>=',$request->get('from_date'))
                                        ->whereDate('created_at','<=',$request->get('to_date'))
                                        ->sum('amount');

            $totalCashExpenses   = Expense::where('payment_method','Cash')
                                        ->whereDate('created_at','>=',$request->get('from_date'))
                                        ->whereDate('created_at','<=',$request->get('to_date'))
                                        ->sum('amount');

            $totalOnlineExpenses = Expense::select('from_account', DB::raw('SUM(amount) as amount'))
                                        ->where('payment_method','Online')
                                        ->whereDate('created_at','>=',$request->get('from_date'))
                                        ->whereDate('created_at','<=',$request->get('to_date'))
                                        ->groupBy('from_account')->get()->toArray();
        }        

        $totalAmount = $totalReceivedAmount;
        // $totalOrderItem = $totalOrderItem->paginate(20);
        $totalOrderItem = $totalOrderItem->paginate(20);


        return view('report',[
            'totalAmount'=>$totalAmount,
            'totalOnlineAmount'=>$totalOnlineAmount,
            'totalCashAmount'=>$totalCashAmount,
            'totalExpenses'=>$totalExpenses,
            'totalCashExpenses'=>$totalCashExpenses,
            'totalOnlineExpenses'=>$totalOnlineExpenses,
            'totalOrderItem'=>$totalOrderItem,
            'from_date'=>$request->get('from_date'),
            'to_date'=>$request->get('to_date'),
        ]);
    }
}
