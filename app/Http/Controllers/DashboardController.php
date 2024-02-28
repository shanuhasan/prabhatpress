<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Expense;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $totalOrder = Order::count();

        // total order amount with discount
            $totalAmount = Order::sum('total_amount');
            $totalDiscount = Order::sum('discount');
            $totalOrderAmount = $totalAmount - $totalDiscount;
        // end total order amount with discount

        //total received amount
            $totalReceivedAmount = OrderItem::sum('amount');
        //end total received amount

        //start orders count
            $totalOrderPending = Order::where('status','Pending')->count();
            $totalOrderComplete = Order::where('status','Completed')->count();
            $totalOrderDelivered = Order::where('status','Delivered')->count();
            $todayOrder = Order::whereDate('created_at','=',$currentDate)->count();
        //end orders count
        
        //today order amount 
            $todayAmount = Order::whereDate('created_at','=',$currentDate)
                                        ->sum('total_amount');
            $todayOrderDiscount = Order::whereDate('created_at','=',$currentDate)
                                        ->sum('discount');
            $todayOrderAmount = $todayAmount - $todayOrderDiscount;
        //end today order amount 
        
        // today received amount
            $todayReceivedAmount = OrderItem::whereDate('created_at','=',$currentDate)
                                            ->sum('amount');
            $todayCashAmount = OrderItem::whereDate('created_at','=',$currentDate)
                                        ->where('payment_method','Cash')
                                        ->sum('amount');
        // end today received amount

        // today enpenses
            $todayExpenses = Expense::whereDate('created_at','=',$currentDate)
                                        ->sum('amount');
            $todayCashExpenses = Expense::whereDate('created_at','=',$currentDate)
                                        ->where('payment_method','Cash')
                                        ->sum('amount');
            $todayOnlineExpenses = Expense::select('from_account', DB::raw('SUM(amount) as amount'))
                                        ->whereDate('created_at','=',$currentDate)
                                        ->where('payment_method','Online')
                                        ->groupBy('from_account')->get()->toArray();
        //end today expenses

        // today online received amount with account name
            $todayOnlineAmount = OrderItem::select('in_account', DB::raw('SUM(amount) as amount'))
                                        ->where('payment_method','Online')
                                        ->whereDate('created_at','=',$currentDate)
                                        ->groupBy('in_account')
                                        ->get()->toArray();
        //end today online received amount with account name

        $totalOrders = Order::where('status','Delivered')->where('is_pending_amount','2')->get();

        $totalSum = 0;
        $orderItemSum = 0;
        $borrowAmount = 0;
        $totalDiscount = 0;
        if( !empty($totalOrders))
        {
            foreach($totalOrders as $vl)
            {
                $totalSum += $vl->total_amount;
                $totalDiscount += $vl->discount;
    
                $orderItemSum += OrderItem::where('order_id',$vl->id)->sum('amount');
            }
    
            $borrowAmount =  $totalSum - $totalDiscount - $orderItemSum;
        }
       

        // print_r($orderItemSum);

        return view('dashboard',[
            'totalOrder'=>$totalOrder,
            'totalOrderAmount'=>$totalOrderAmount,
            'totalReceivedAmount'=>$totalReceivedAmount,
            'todayExpenses'=>$todayExpenses,
            'todayCashExpenses'=>$todayCashExpenses,
            'todayOnlineExpenses'=>$todayOnlineExpenses,
            'todayOrder'=>$todayOrder,
            'totalOrderPending'=>$totalOrderPending,
            'totalOrderComplete'=>$totalOrderComplete,
            'totalOrderDelivered'=>$totalOrderDelivered,
            'todayOrderAmount'=>$todayOrderAmount,
            'todayReceivedAmount'=>$todayReceivedAmount,
            'todayCashAmount'=>$todayCashAmount,
            'todayOnlineAmount'=>$todayOnlineAmount,
            'borrowAmount'=>$borrowAmount,
        ]);
    }
}
