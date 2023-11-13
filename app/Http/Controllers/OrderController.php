<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::latest(); 

        if(!empty($request->get('keyword')))
        {
            $orders = $orders->where('particular','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('customer_name','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('phone','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('order_no','like','%'.$request->get('keyword').'%');
        }

        $orders = $orders->paginate(20);

        $data['orders'] = $orders;
        return view('orders.index',$data);
    }

    public function pending(Request $request)
    {
        $orders = Order::where('status','Pending')->orderBy('id', 'ASC'); 

        if(!empty($request->get('keyword')))
        {
            $orders = $orders->where('particular','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('customer_name','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('phone','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('order_no','like','%'.$request->get('keyword').'%');
        }

        $orders = $orders->paginate(20);

        $data['orders'] = $orders;
        return view('orders.pending',$data);
    }

    public function complete(Request $request)
    {
        $orders = Order::where('status','Complete')->orderBy('id', 'ASC'); 

        if(!empty($request->get('keyword')))
        {
            $orders = $orders->where('particular','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('customer_name','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('phone','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('order_no','like','%'.$request->get('keyword').'%');
        }

        $orders = $orders->paginate(20);

        $data['orders'] = $orders;
        return view('orders.complete',$data);
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'order_no'=>'required|unique:orders',
            'customer_name'=>'required',
            'phone'=>'required|min:10',
            'particular'=>'required',
            'total_amount'=>'required',
            'payment_method'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){
            $model = new Order();
            $model->order_no = $request->order_no;
            $model->customer_name = $request->customer_name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->total_amount = $request->total_amount;
            $model->status = $request->status;
            $model->created_by = Auth::user()->id;
            if($model->save())
            {
                if(!empty($request->advance_amount) && $request->advance_amount > 0)
                {
                    $orderDetail = new OrderItem();
                    $orderDetail->order_id = $model->id;
                    $orderDetail->amount = $request->advance_amount;
                    $orderDetail->payment_method = $request->payment_method;
                    if($request->payment_method == 'Online')
                    {
                        $orderDetail->in_account = $request->in_account;
                    }
                    $orderDetail->updated_by = Auth::user()->id;
                    $orderDetail->save();
                }
            }

            return redirect()->route('orders.index')->with('success','Order has been created successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function edit($id , Request $request){

        $order = Order::find($id);
        if(empty($order))
        {
            return redirect()->route('orders.index');
        }

        $orderDetail = OrderItem::where('order_id',$order->id)->get();

        $data['order'] = $order;
        $data['orderDetail'] = $orderDetail;

        return view('orders.edit',$data);
        
    }
    public function update($id, Request $request){

        $model = Order::find($id);
        if(empty($model))
        {
            return redirect()->route('orders.index')->with('error','Order not found.');
        }

        $validator = Validator::make($request->all(),[
            'customer_name'=>'required',
            'phone'=>'required|min:10',
            'particular'=>'required',
            'total_amount'=>'required',
            'payment_method'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->customer_name = $request->customer_name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->total_amount = $request->total_amount;
            $model->status = $request->status;
            $model->updated_by = Auth::user()->id;
            if($model->save())
            {
                if(!empty($request->advance_amount) && $request->advance_amount > 0)
                {
                    $orderDetail = new OrderItem();
                    $orderDetail->order_id = $model->id;
                    $orderDetail->amount = $request->advance_amount;
                    $orderDetail->payment_method = $request->payment_method;
                    if($request->payment_method == 'Online')
                    {
                        $orderDetail->in_account = $request->in_account;
                    }
                    $orderDetail->updated_by = Auth::user()->id;
                    $orderDetail->save();
                }
            }

            return redirect()->route('orders.index')->with('success','Order updated successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }
}
