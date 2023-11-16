<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerPayment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrder = Order::count();
        $totalOrderAmount = Order::sum('total_amount');
        $totalReceivedAmount = OrderItem::sum('amount');

        //this month revenue
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $totalOrderAmountCurrentMonth = Order::whereDate('created_at','>=',$startOfMonth)
                                            ->whereDate('created_at','<=',$currentDate)
                                            ->sum('total_amount');
        
        // last month revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonth= Carbon::now()->subMonth()->startOfMonth()->format('M');

        $totalOrderAmountLastMonth = Order::whereDate('created_at','>=',$lastMonthStartDate)
                                            ->whereDate('created_at','<=',$lastMonthEndDate)
                                            ->sum('total_amount');
        // last 30 days revenue
        $lastThirtyDate = Carbon::now()->subDays(30)->format('Y-m-d');

        $totalOrderAmountLastThirtyDays = Order::whereDate('created_at','>=',$lastThirtyDate)
                                            ->whereDate('created_at','<=',$currentDate)
                                            ->sum('total_amount');

        //current
        $totalOrderPending = Order::where('status','Pending')->count();
        $totalOrderComplete = Order::where('status','Complete')->count();

        $todayOrder = Order::whereDate('created_at','=',$currentDate)->count();
        
        $todayOrderAmount = Order::whereDate('created_at','=',$currentDate)
                                    ->sum('total_amount');
        
        $todayReceivedAmount = OrderItem::whereDate('created_at','=',$currentDate)
                                        ->sum('amount');
        $todayCustomerReceivedAmount = CustomerPayment::whereDate('created_at','=',$currentDate)
                                        ->sum('amount');

        $todayOnlineAmount = OrderItem::select('in_account', DB::raw('SUM(amount) as amount'))
                                        ->where('payment_method','Online')
                                        ->whereDate('created_at','=',$currentDate)
                                        ->groupBy('in_account')
                                        ->get()->toArray();

        // customer payments
        $todayCustomerOnlineAmount = CustomerPayment::select('in_account', DB::raw('SUM(amount) as amount'))
                                        ->where('payment_method','Online')
                                        ->whereDate('created_at','=',$currentDate)
                                        ->groupBy('in_account')
                                        ->get()->toArray();

        $totalOnlineArr = array_merge($todayOnlineAmount,$todayCustomerOnlineAmount);

        $finalTotalOnlineArr = array_reduce($totalOnlineArr, function($result, $item){ 
            if(!isset($result[$item['in_account']])){ 
                $result[$item['in_account']] = ['in_account'=>$item['in_account'],'amount'=>$item['amount']]; 
            } else { 
                $result[$item['in_account']]['amount'] += $item['amount']; 
            } 
            return $result; 
        });

        // echo "<pre>";print_r($finalTotalOnlineArr);die;

        return view('dashboard',[
            'totalOrder'=>$totalOrder,
            'totalOrderAmount'=>$totalOrderAmount,
            'totalReceivedAmount'=>$totalReceivedAmount,
            'totalOrderAmountCurrentMonth'=>$totalOrderAmountCurrentMonth,
            'totalOrderAmountLastMonth'=>$totalOrderAmountLastMonth,
            'totalOrderAmountLastThirtyDays'=>$totalOrderAmountLastThirtyDays,
            'lastMonth'=>$lastMonth,
            'todayOrder'=>$todayOrder,
            'totalOrderPending'=>$totalOrderPending,
            'totalOrderComplete'=>$totalOrderComplete,
            'todayOrderAmount'=>$todayOrderAmount,
            'todayReceivedAmount'=>$todayReceivedAmount + $todayCustomerReceivedAmount,
            // 'todayOnlineAmount'=>$todayOnlineAmount,
            'todayOnlineAmount'=>$finalTotalOnlineArr,
        ]);
    }
}
