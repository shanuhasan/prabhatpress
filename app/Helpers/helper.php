<?php

use App\Models\User;


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
