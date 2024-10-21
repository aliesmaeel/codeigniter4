<?php

namespace App\Validation;
use App\Models\User;
use App\Libraries\SessionAuth;
use App\Libraries\Hash;

class IsCurrentPasswordCorrect
{
     public function check_current_password($password): bool
     {
         $password=trim($password);
         $user=new User();
         $user_id=SessionAuth::id();
         $user_info=$user->asObject()->where('id',$user_id)->first();

         if(Hash::check($password,$user_info->password)){
             return true;
         }
         return false;
     }
}
