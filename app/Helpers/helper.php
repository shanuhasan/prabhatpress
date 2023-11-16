<?php

use App\Models\User;
use App\Models\Customer;


function getUserName($id)
{
    $user =  User::find($id);
    
    if(empty($user))
    {
        return '';
    }
    return $user->name;
}

function getUsers()
{
    $user =  User::where('status',1)->get();
    
    if(empty($user))
    {
        return [];
    }
    
    return $user;
}

function getCustomerName($id)
{
    $customer =  Customer::find($id);
    
    if(empty($customer))
    {
        return '';
    }
    return $customer->name;
}

function getCustomerPhone($id)
{
    $customer =  Customer::find($id);
    
    if(empty($customer))
    {
        return '';
    }
    return $customer->phone;
}

function getCustomerDetail($id)
{
    $customer =  Customer::find($id);
    
    if(empty($customer))
    {
        return '';
    }
    return $customer;
}

function numberOfDays($date1,$date2)
{
    $d1=date_create($date1);
    $d2=date_create($date2);
    $diff=date_diff($d1,$d2);
    return $diff->format("%R%a");
}

function statusColor($status)
{
    if($status == 'Pending')
    {
        $style = 'background:red;color:#fff;';
    }else if($status == 'Delivered')
    {
        $style = 'background:green;color:#fff;';
    }else{
        $style = 'background:orange;color:#fff;';
    }
    return $style;
}


