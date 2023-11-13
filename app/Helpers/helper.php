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
