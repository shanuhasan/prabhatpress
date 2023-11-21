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
        $orders = Order::where('status','Completed')->orderBy('id', 'ASC'); 

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

    public function delivered(Request $request)
    {
        $orders = Order::where('status','Delivered')->orderBy('id', 'ASC'); 

        if(!empty($request->get('keyword')))
        {
            $orders = $orders->where('particular','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('customer_name','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('phone','like','%'.$request->get('keyword').'%');
            $orders = $orders->orWhere('order_no','like','%'.$request->get('keyword').'%');
        }

        $orders = $orders->paginate(20);

        $data['orders'] = $orders;
        return view('orders.delivered',$data);
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
            $model->delivery_at = $request->delivery_at;
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
            // 'total_amount'=>'required',
            'payment_method'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->customer_name = $request->customer_name;
            $model->phone = $request->phone;
            $model->address = $request->address;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->discount = $request->discount;
            $model->status = $request->status;
            $model->delivery_at = $request->delivery_at;
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

    public function delete($id, Request $request)
    {
        $model = Order::find($id);
        $orderItem = OrderItem::where('order_id',$id)->get();


        if(empty($model))
        {
            $request->session()->flash('error','Order not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Order not found.'
            ]);
        }

        if(!empty($orderItem))
        {
            foreach($orderItem as $item)
            {
                $detailModel = OrderItem::find($item->id);
                $detailModel->delete();
            }
        }

        $model->delete();

        $request->session()->flash('success','Order deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Order deleted successfully.'
        ]);
    }

    public function deleteItem($id, Request $request)
    {
        $model = OrderItem::find($id);

        if(empty($model))
        {
            $request->session()->flash('error','Order Item not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Order Item not found.'
            ]);
        }

        $model->delete();

        $request->session()->flash('success','Order Item deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Order Item deleted successfully.'
        ]);
    }

    public function print($id)
    {
        $order = Order::find($id);
        if(empty($order))
        {
            return redirect()->route('orders.index');
        }

        $orderDetail = OrderItem::where('order_id',$order->id)->get();

        $advAmt = 0;
        if (!empty($orderDetail)) {
            foreach ($orderDetail as $k => $vl) {
                $advAmt += $vl->amount;
            }
        }

        $data['order'] = $order;
        $data['orderDetail'] = $orderDetail;
        $data['advAmt'] = $advAmt;

        return view('orders.print',$data);
    }
}
