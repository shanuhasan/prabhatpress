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
        $totalExpenses = Expense::sum('amount');
        $totalOrderItem = OrderItem::orderBy('id','DESC');

        if(!empty($request->get('from_date')) && !empty($request->get('to_date')))
        {
            $totalReceivedAmount = OrderItem::
                                            whereDate('created_at','>=',$request->get('from_date'))
                                            ->whereDate('created_at','<=',$request->get('to_date'))
                                            ->sum('amount');

            $totalExpenses = Expense::
                                    whereDate('created_at','>=',$request->get('from_date'))
                                    ->whereDate('created_at','<=',$request->get('to_date'))
                                    ->sum('amount');

            $totalOrderItem = OrderItem::whereDate('created_at','>=',$request->get('from_date'))
                                    ->whereDate('created_at','<=',$request->get('to_date'));
        }

        if(!empty($request->get('from_date')))
        {
            $totalReceivedAmount = OrderItem::
                                            whereDate('created_at','=',$request->get('from_date'))
                                            ->sum('amount');

            $totalExpenses = Expense::
                                    whereDate('created_at','=',$request->get('from_date'))
                                    ->sum('amount');

            $totalOrderItem = OrderItem::whereDate('created_at','=',$request->get('from_date'));
        }

        $totalAmount = $totalReceivedAmount;
        // $totalOrderItem = $totalOrderItem->paginate(20);
        $totalOrderItem = $totalOrderItem->paginate(20);


        return view('report',[
            'totalAmount'=>$totalAmount,
            'totalExpenses'=>$totalExpenses,
            'totalOrderItem'=>$totalOrderItem,
            'from_date'=>$request->get('from_date'),
            'to_date'=>$request->get('to_date'),
        ]);
    }
}
