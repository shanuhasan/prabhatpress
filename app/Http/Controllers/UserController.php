<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest();

        if(!empty($request->get('keyword')))
        {
            $users = $users->where('name','like','%'.$request->get('keyword').'%');
        }

        $users = $users->paginate(10);

        return view('user.index',[
            'users'=>$users
        ]);
    }

    public function create(){

        return view('user.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'phone'=>'required|numeric|min:10',
            'status'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|confirmed',
        ]);

        if($validator->passes())
        {
            $model = new User();
            $model->name = $request->name;
            $model->email = $request->email;
            $model->phone = $request->phone;
            $model->role = 1;
            $model->status = $request->status;
            $model->password = Hash::make($request->password);
            $model->save();

            return redirect()->route('user.index')->with('success','User added successfully.');
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function edit($id , Request $request){

        $user = User::find($id);
        if(empty($user))
        {
            return redirect()->route('user.index');
        }

        return view('user.edit',compact('user'));        
    }

    public function update($id, Request $request){

        $model = User::find($id);
        if(empty($model))
        {
            return redirect()->back()->with('error','User not found.');
        }

        $validator = Validator::make($request->all(),[
            'email'=>'required|email|unique:users,email,'.$id.',id',
            'name'=>'required|min:3',
            'phone'=>'required|numeric|min:10',
            'status'=>'required',
        ]);

        if($validator->passes()){

            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->status = $request->status;

            if($request->password !="")
            {
                $model->password = Hash::make($request->password);
            }

            $model->save();

            return redirect()->route('user.index')->with('success','User updated successfully.');

        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function destroy($id, Request $request){
        $model = User::find($id);
        if(empty($model))
        {
            return redirect()->back()->with('error','User not found.');
        }

        $model->status = 0;
        $model->save();
        // $model->delete();

        return redirect()->back()->with('success','User deleted successfully.');

    }
}
