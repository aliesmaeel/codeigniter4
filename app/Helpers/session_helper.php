<?php

use App\Libraries\SessionAuth;
use App\Models\User;

if (!function_exists('get_user')){
    function get_user()
    {
        if (SessionAuth::isAuthenticated()){
            $user=new User();
            return $user->asObject()->where('id',SessionAuth::id())->first();
        }else {
            return null;
        }
    }
}