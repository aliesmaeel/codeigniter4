<?php

namespace App\Validation;

use App\Libraries\SessionAuth;

class AuthValidation
{
    public static function getLoginRules($fieldType)
    {
        $rules = [
            'password' => [
                'rules' => 'required|min_length[5]|max_length[45]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password is too short, at least 5',
                    'max_length' => 'Password is too long, at most 45'
                ]
            ]
        ];

        if ($fieldType === 'email') {
            $rules['login_id'] = [
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email',
                    'is_not_unique' => 'Email is not in our system'
                ]
            ];
        } else {
            $rules['login_id'] = [
                'rules' => 'required|is_not_unique[users.username]',
                'errors' => [
                    'required' => 'Username is required',
                    'is_not_unique' => 'Username is not in our system'
                ]
            ];
        }

        return $rules;
    }
    public static function getChangePasswordRules(){
        return [
            'current_password'=>[
                'rules'=>'required|min_length[5]|check_current_password[current_password]',
                'errors'=>[
                    'required' => 'Enter Current password',
                    'min_length' => 'Password must be longer than 5 chars',
                    'check_current_password' => 'The Current Password is not correct',
                ]
               ],
            'new_password' => [
                'rules' => 'required|min_length[5]|max_length[20]|is_password_strong[new_password]',
                'errors' => [
                    'required' => 'Enter new password',
                    'min_length' => 'Password must be longer than 5 chars',
                    'max_length' => 'Password must be shorter than 20 chars',
                    'is_password_strong' => 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special char'
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Confirm new password',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ];
    }
    public static function getPasswordResetRules()
    {
        return [
            'new_password' => [
                'rules' => 'required|min_length[5]|max_length[20]|is_password_strong[new_password]',
                'errors' => [
                    'required' => 'Enter new password',
                    'min_length' => 'Password must be longer than 5 chars',
                    'max_length' => 'Password must be shorter than 20 chars',
                    'is_password_strong' => 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special char'
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Confirm new password',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ];
    }

    public static function getProfileRules(){
        $userId=SessionAuth::id();
        return [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Name is required',
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[4]|is_unique[users.username,id,'.$userId.']',
                'errors' => [
                    'required' => 'Username is required ',
                    'min_length' => 'Username must be longer than 4 chars ',
                    'is_unique' => 'Username is already taken ',
                ]
            ]
        ];
    }
}
