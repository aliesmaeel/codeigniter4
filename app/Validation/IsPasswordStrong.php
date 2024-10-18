<?php

namespace App\Validation;

class IsPasswordStrong
{
     public function is_password_strong($password): bool
     {
         $password = trim($password);
         $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&*()])[A-Za-z\d@#$%^&*()]{5,}$/';

         if (preg_match($pattern, $password))
             return true;

         return false;

     }
}
