<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;


function getUserName($id)
{
    $user =  User::find($id);

    if (empty($user)) {
        return 'NA';
    }
    return $user->name;
}

function getUsers()
{
    $user =  User::where('status', 1)->get();

    if (empty($user)) {
        return [];
    }

    return $user;
}

function getCustomerName($id)
{
    $customer =  Customer::find($id);

    if (empty($customer)) {
        return 'NA';
    }
    return $customer->name;
}

function getCustomerCompany($id)
{
    $customer =  Customer::find($id);

    if (empty($customer)) {
        return 'NA';
    }
    return $customer->company;
}

function getCustomerPhone($id)
{
    $customer =  Customer::find($id);

    if (empty($customer)) {
        return 'NA';
    }
    return $customer->phone;
}

function getCustomerDetail($id)
{
    $customer =  Customer::find($id);

    if (empty($customer)) {
        return 'NA';
    }
    return $customer;
}

function numberOfDays($date1, $date2)
{
    $d1 = date_create($date1);
    $d2 = date_create($date2);
    $diff = date_diff($d1, $d2);
    return $diff->format("%R%a");
}

function statusColor($status)
{
    if ($status == 'Pending') {
        $style = 'background:red;color:#fff;';
    } else if ($status == 'Delivered') {
        $style = 'background:green;color:#fff;';
    } else {
        $style = 'background:orange;color:#fff;';
    }
    return $style;
}

function getCustomerNameFromOrder($id)
{
    $order =  Order::find($id);

    if (empty($order)) {
        return 'NA';
    }
    return $order->customer_name;
}

function statusList()
{
    $list = [
        'Pending' => 'Pending',
        'Printing' => 'Printing',
        'Completed' => 'Completed',
        'Delivered' => 'Delivered',
    ];

    return $list;
}

function years()
{
    $arr = [];
    for ($i = 2020; $i <= date('Y'); $i++) {
        $arr[$i] = $i;
    }
    return $arr;
}
