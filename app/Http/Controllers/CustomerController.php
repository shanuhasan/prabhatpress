<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
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
        return view('customer.orders',compact('orders'));
    }
}
