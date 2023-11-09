<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
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
            'customer_name'=>'required',
            'particular'=>'required',
            'total_amount'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model = new Order();
            $model->customer_name = $request->customer_name;
            $model->phone = $request->phone;
            $model->particular = $request->particular;
            $model->total_amount = $request->total_amount;
            $model->advance_amount = $request->advance_amount;
            $model->balance_amount = $request->balance_amount;
            $model->status = $request->status;
            $model->save();

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

        return view('orders.edit',compact('order'));
        
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
            $model->particular = $request->particular;
            $model->total_amount = $request->total_amount;
            $model->advance_amount = $request->advance_amount;
            $model->balance_amount = $request->balance_amount;
            $model->status = $request->status;
            $model->save();

            return redirect()->route('orders.index')->with('success','Order updated successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }
}
