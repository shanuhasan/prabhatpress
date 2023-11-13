<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::where('status',1)->latest();

        if(!empty($request->get('keyword')))
        {
            $customers = $customers->where('name','like','%'.$request->get('keyword').'%');
        }

        $customers = $customers->paginate(10);

        return view('customer.index',[
            'customers'=>$customers
        ]);
    }

    public function create(){

        return view('customer.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'phone'=>'required|numeric|min:10|unique:customers',
        ]);

        if($validator->passes())
        {
            $model = new Customer();
            $model->name = $request->name;
            $model->email = $request->email;
            $model->phone = $request->phone;
            $model->company = $request->company;
            $model->address = $request->address;
            $model->status = 1;
            $model->save();

            return redirect()->route('customer.index')->with('success','Customer added successfully.');
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function edit($id , Request $request){

        $customer = Customer::find($id);
        if(empty($customer))
        {
            return redirect()->route('customer.index');
        }

        return view('customer.edit',compact('customer'));        
    }

    public function update($id, Request $request){

        $model = Customer::find($id);
        if(empty($model))
        {
            return redirect()->back()->with('error','Customer not found.');
        }

        $validator = Validator::make($request->all(),[
            // 'email'=>'required|email|unique:users,email,'.$id.',id',
            'name'=>'required|min:3',
            'phone'=>'required|numeric|min:10|unique:customers,phone,'.$id.',id',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->email = $request->email;
            $model->company = $request->company;
            $model->address = $request->address;

            $model->save();

            return redirect()->route('customer.index')->with('success','Customer updated successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function destroy($id, Request $request){
        $model = Customer::find($id);

        if(empty($model))
        {
            $request->session()->flash('error','Customer not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Customer not found.'
            ]);
        }

        $model->status = 0;
        $model->save();
        // $model->delete();

        $request->session()->flash('success','Customer deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Customer deleted successfully.'
        ]);


    }

    public function orders($id){
        $orders = Order::where('customer_id',$id)->paginate(10);
        $data['orders'] = $orders;
        $data['customerId'] = $id;

        //total order amount customer
        $totalAmount = Order::where('customer_id',$id)->sum('total_amount');

        $totalAmountReceived = 0;

        if($orders!=null)
        {
            foreach($orders as $key => $item)
            {
                $totalAmountReceived += OrderItem::where('order_id',$item->id)->sum('amount');
            }
        }  
        
        // echo "<pre>";print_r($orderDetail);die;
        $customerTotalPayment = CustomerPayment::where('customer_id',$id)->sum('amount');
        $customerPayment = CustomerPayment::where('customer_id',$id)->get();

        $data['totalAmount'] = $totalAmount;
        $data['totalAmountReceived'] = $totalAmountReceived;
        $data['customerTotalPayment'] = $customerTotalPayment;
        $data['customerPayment'] = $customerPayment;
        return view('customer.orders',$data);
    }

    public function orderCreate($id){
        $customerId = $id;
        return view('customer.order-create',compact('customerId'));
    }

    public function orderStore(Request $request){
        $validator = Validator::make($request->all(),[
            'order_no'=>'required|unique:orders',
            'customer_id'=>'required',
            'particular'=>'required',
            'total_amount'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){
            $model = new Order();
            $model->order_no = $request->order_no;
            $model->customer_id = $request->customer_id;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->total_amount = $request->total_amount;
            $model->status = $request->status;
            $model->delivery_at = $request->delivery_at;
            $model->created_by = Auth::user()->id;
            $model->save();
            // if($model->save())
            // {
            //     if(!empty($request->advance_amount) && $request->advance_amount > 0)
            //     {
            //         $orderDetail = new OrderItem();
            //         $orderDetail->order_id = $model->id;
            //         $orderDetail->amount = $request->advance_amount;
            //         $orderDetail->payment_method = $request->payment_method;
            //         if($request->payment_method == 'Online')
            //         {
            //             $orderDetail->in_account = $request->in_account;
            //         }
            //         $orderDetail->updated_by = Auth::user()->id;
            //         $orderDetail->save();
            //     }
            // }

            return redirect()->route('customer.order',$request->customer_id)->with('success','Order has been created successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function orderEdit($customerId,$orderId){

        $order = Order::where('id',$orderId)
                        ->where('customer_id',$customerId)
                        ->first();
        if(empty($order))
        {
            return redirect()->route('orders.index');
        }

        $orderDetail = OrderItem::where('order_id',$order->id)->get();

        $data['order'] = $order;
        $data['orderDetail'] = $orderDetail;
        $data['customerId'] = $customerId;

        return view('customer.order-edit',$data);
        
    }

    public function orderUpdate($id, Request $request){

        $model = Order::find($id);
        if(empty($model))
        {
            return redirect()->route('orders.index')->with('error','Order not found.');
        }

        $validator = Validator::make($request->all(),[
            'particular'=>'required',
            'total_amount'=>'required',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->total_amount = $request->total_amount;
            $model->status = $request->status;
            $model->delivery_at = $request->delivery_at;
            $model->updated_by = Auth::user()->id;
            $model->save();
            // if($model->save())
            // {
            //     if(!empty($request->advance_amount) && $request->advance_amount > 0)
            //     {
            //         $orderDetail = new OrderItem();
            //         $orderDetail->order_id = $model->id;
            //         $orderDetail->amount = $request->advance_amount;
            //         $orderDetail->payment_method = $request->payment_method;
            //         if($request->payment_method == 'Online')
            //         {
            //             $orderDetail->in_account = $request->in_account;
            //         }
            //         $orderDetail->updated_by = Auth::user()->id;
            //         $orderDetail->save();
            //     }
            // }

            return redirect()->route('customer.order',$model->customer_id)->with('success','Order updated successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function orderPayment(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount'=>'required|numeric',
            'payment_method'=>'required',
        ]);

        if($validator->passes())
        {
            if(!empty($request->amount) && $request->amount > 0)
            {
                $model = new CustomerPayment();
                $model->customer_id = $request->customer_id;
                $model->amount = $request->amount;
                $model->payment_method = $request->payment_method;
                if($request->payment_method == 'Online')
                {
                    $model->in_account = $request->in_account;
                }
                $model->updated_by = Auth::user()->id;
                $model->save();
            }
            return redirect()->back()->with('success','Payment updated successfully.');
        }else{
            return Redirect::back()->withErrors($validator);
        }
        
    }

    public function orderDelete($id, Request $request)
    {
        $model = Order::find($id);

        if(empty($model))
        {
            $request->session()->flash('error','Order not found.');
            return response()->json([
                'status'=>true,
                'message'=>'Order not found.'
            ]);
        }

        $model->delete();

        $request->session()->flash('success','Order deleted successfully.');

        return response()->json([
            'status'=>true,
            'message'=>'Order deleted successfully.'
        ]);
    }
}
