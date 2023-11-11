<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::orderBy('id', 'ASC'); 

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

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'order_no'=>'required',
            'customer_name'=>'required',
            'phone'=>'required',
            'particular'=>'required',
            'total_amount'=>'required',
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
            if($model->save())
            {
                $orderDetail = new OrderItem();
                $orderDetail->order_id = $model->id;
                $orderDetail->amount = $request->advance_amount;
                $orderDetail->save();
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
            'particular'=>'required',
            'total_amount'=>'required',
            'status'=>'required',
            // 'slug'=>'required|unique:brands,slug,'.$model->id.',id',
        ]);

        if($validator->passes()){

            $model->customer_name = $request->customer_name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->total_amount = $request->total_amount;
            $model->status = $request->status;
            if($model->save())
            {
                if(!empty($request->advance_amount) && $request->advance_amount > 0)
                {
                    $orderDetail = new OrderItem();
                    $orderDetail->order_id = $model->id;
                    $orderDetail->amount = $request->advance_amount;
                    $orderDetail->save();
                }
                
            }

            return redirect()->route('orders.index')->with('success','Order updated successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }
}
