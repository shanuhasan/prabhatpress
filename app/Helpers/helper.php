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
