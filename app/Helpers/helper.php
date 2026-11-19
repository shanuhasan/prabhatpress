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
    // Soft "pill" tones used for the order status column.
    $base = 'font-weight:600;font-size:.8rem;';
    if ($status == 'Pending') {
        $style = 'color:#c0262d;background-color:#fef2f2;';
    } else if ($status == 'Delivered') {
        $style = 'color:#047857;background-color:#ecfdf5;';
    } else if ($status == 'Completed') {
        $style = 'color:#4338ca;background-color:#eef0ff;';
    } else {
        $style = 'color:#b45309;background-color:#fff7ed;';
    }
    return $base . $style;
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

function GUIDv4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        if ($trim === true)
            return trim(com_create_guid(), '{}');
        else
            return com_create_guid();
    }

    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // Fallback (PHP 4.2+)
    mt_srand((float)microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);                  // "-"
    $lbrace = $trim ? "" : chr(123);    // "{"
    $rbrace = $trim ? "" : chr(125);    // "}"
    $guidv4 = $lbrace .
        substr($charid,  0,  8) . $hyphen .
        substr($charid,  8,  4) . $hyphen .
        substr($charid, 12,  4) . $hyphen .
        substr($charid, 16,  4) . $hyphen .
        substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}

function type($key = null)
{
    $list = [
        '1' => 'Flex',
        '2' => 'Other',
    ];

    return !empty($key) ? $list[$key] : $list;
}

/**
 * Format an amount in Indian style: 123456.5 => "₹1,23,456.50".
 * Whole numbers drop the decimals: 2500 => "₹2,500".
 */
function money($amount, $symbol = '₹')
{
    $amount = (float) $amount;
    $negative = $amount < 0;
    $amount = abs($amount);

    $decimals = fmod($amount, 1) != 0 ? 2 : 0;
    $parts = explode('.', number_format($amount, $decimals, '.', ''));
    $int = $parts[0];

    if (strlen($int) > 3) {
        $last3 = substr($int, -3);
        $rest = substr($int, 0, -3);
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        $int = $rest . ',' . $last3;
    }

    $formatted = $symbol . $int . (isset($parts[1]) ? '.' . $parts[1] : '');

    return $negative ? '-' . $formatted : $formatted;
}

function pre($data)
{
    echo "<pre>";
    print_r($data);
    die;
}
