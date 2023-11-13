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

function dateDiffrence($date1,$date2)
{
    $date1 = "2007-03-24";
    $date2 = "2009-06-26";

    $diff = abs(strtotime($date2) - strtotime($date1));

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

    $data['years'] = $years;
    $data['months'] = $months;
    $data['days'] = $days;

    return $data;
}
