<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Expense;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    private $companyId;

    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function ($request, $next){
            $this->companyId = Auth::user()->company_id;
            return $next($request);
        });
    }

    public function index()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $totalOrder = Order::where('company_id',$this->companyId)->count();

        // total order amount with discount
            $totalAmount = Order::where('company_id',$this->companyId)->sum('total_amount');
            $totalDiscount = Order::where('company_id',$this->companyId)->sum('discount');
            $totalOrderAmount = $totalAmount - $totalDiscount;
        // end total order amount with discount

        //total received amount
            $totalReceivedAmount = OrderItem::where('company_id',$this->companyId)->sum('amount');
        //end total received amount

        //start orders count
            $totalOrderPending = Order::where('company_id',$this->companyId)->where('status','Pending')->count();
            $totalOrderComplete = Order::where('company_id',$this->companyId)->where('status','Completed')->count();
            $totalOrderDelivered = Order::where('company_id',$this->companyId)->where('status','Delivered')->count();
            $todayOrder = Order::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)->count();
        //end orders count
        
        //today order amount 
            $todayAmount = Order::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)
                                        ->sum('total_amount');
            $todayOrderDiscount = Order::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)
                                        ->sum('discount');
            $todayOrderAmount = $todayAmount - $todayOrderDiscount;
        //end today order amount 
        
        // today received amount
            $todayReceivedAmount = OrderItem::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)
                                            ->sum('amount');
            $todayCashAmount = OrderItem::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)
                                        ->where('payment_method','Cash')
                                        ->sum('amount');
        // end today received amount

        // today enpenses
            $todayExpenses = Expense::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)
                                        ->sum('amount');
            $todayCashExpenses = Expense::where('company_id',$this->companyId)->whereDate('created_at','=',$currentDate)
                                        ->where('payment_method','Cash')
                                        ->sum('amount');
            $todayOnlineExpenses = Expense::select('from_account', DB::raw('SUM(amount) as amount'))
                                        ->where('company_id',$this->companyId)
                                        ->whereDate('created_at','=',$currentDate)
                                        ->where('payment_method','Online')
                                        ->groupBy('from_account')->get()->toArray();
        //end today expenses

        // today online received amount with account name
            $todayOnlineAmount = OrderItem::select('in_account', DB::raw('SUM(amount) as amount'))
                                        ->where('company_id',$this->companyId)
                                        ->where('payment_method','Online')
                                        ->whereDate('created_at','=',$currentDate)
                                        ->groupBy('in_account')
                                        ->get()->toArray();
        //end today online received amount with account name

        $totalOrders = Order::where('company_id',$this->companyId)
                                ->where('status','Delivered')
                                ->where('is_pending_amount','2')
                                ->get();

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
    
                $orderItemSum += OrderItem::where('company_id',$this->companyId)->where('order_id',$vl->id)->sum('amount');
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
