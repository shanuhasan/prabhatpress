<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

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
        
        $todayOrderAmount = Order::whereDate('created_at','=',$currentDate)
                                    ->sum('total_amount');
        $todayReceivedAmount = OrderItem::whereDate('created_at','=',$currentDate)
                                        ->sum('amount');

        return view('dashboard',[
            'totalOrder'=>$totalOrder,
            'totalOrderAmount'=>$totalOrderAmount,
            'totalReceivedAmount'=>$totalReceivedAmount,
            'totalOrderAmountCurrentMonth'=>$totalOrderAmountCurrentMonth,
            'totalOrderAmountLastMonth'=>$totalOrderAmountLastMonth,
            'totalOrderAmountLastThirtyDays'=>$totalOrderAmountLastThirtyDays,
            'lastMonth'=>$lastMonth,
            'totalOrderPending'=>$totalOrderPending,
            'totalOrderComplete'=>$totalOrderComplete,
            'todayOrderAmount'=>$todayOrderAmount,
            'todayReceivedAmount'=>$todayReceivedAmount,
        ]);
    }
}
