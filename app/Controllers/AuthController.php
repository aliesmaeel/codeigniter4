<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Carbon\Carbon;
use CodeIgniter\HTTP\ResponseInterface;
use  App\Libraries\CIAuth;
use  App\Libraries\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;

helper('email_helper');


class AuthController extends BaseController
{
    protected $helpers=['url','form'];

    public function loginForm()
    {
        $data=[
            'pageTitle'=>'Login',
            'validation'=>null
        ];
        return view('backend/pages/auth/login',$data);
    }

    public function loginHandler(){
        $fieldType=
            filter_var(
                $this->request->getVar('login_id'),FILTER_VALIDATE_EMAIL) ? 'email':'username';

        if ($fieldType=='email'){
                $isValid=$this->validate([
                   'login_id'=>[
                       'rules'=>'required|valid_email|is_not_unique[users.email]',
                       'errors'=>[
                           'required'=>'Email is required',
                           'valid_email'=>'Please enter a valid email',
                           'is_not_unique'=>'Email is not in our system'
                       ]
                   ],
                    'password'=>[
                        'rules'=>'required|min_length[5]|max_length[45]',
                        'errors'=>[
                            'required'=>'Password is required',
                            'min_length'=>'Password is too short  at least 5',
                            'max_length'=>'Password is too long , at most 45 '
                        ]
                    ]
                ]);
        }else{
            $isValid=$this->validate([
                'login_id'=>[
                    'rules'=>'required|is_not_unique[users.username]',
                    'errors'=>[
                        'required'=>'Username is required',
                        'is_not_unique'=>'Username is not in our system'
                    ]
                ],
                'password'=>[
                    'rules'=>'required|min_length[5]|max_length[45]',
                    'errors'=>[
                        'required'=>'Password is required',
                        'min_length'=>'Password is too short  at least 5',
                        'max_length'=>'Password is too long , at most 45 '
                    ]
                ]
            ]);
        }
        if (!$isValid){

            return view('backend/pages/auth/login',[
               'pageTitle'=>'Login',
                'validation'=>$this->validator
            ]);
        }else{
            $user=new User();
            $userInfo=$user->where($fieldType,$this->request->getVar('login_id'))->first();
            $check_password=Hash::check($this->request->getVar('password'),$userInfo['password']);

            if(!$check_password){
                return redirect()->route('admin.login.form')
                    ->with('fail','Wrong Password')
                    ->withInput();
            }else{
                CIAuth::setCIAuth($userInfo);
                return redirect()->route('admin.home');
            }
        }
    }

    public function forgotForm(){
        $data=[
            'pageTitle'=>'Forgot Password',
            'validation'=>null
        ];
        return view('backend/pages/auth/forgot',$data);
    }

    public function sendPasswordResetLink(){

        $isValid=$this->validate([
            'email'=>[
                'rules'=>'required|valid_email|is_not_unique[users.email]',
                'errors'=>[
                    'required'=>'Email is required',
                    'valid_email'=>'Please enter a valid email',
                    'is_not_unique'=>'Email is not in our system'
                ]
            ],
        ]);

        if (!$isValid){

            return view('backend/pages/auth/forgot',[
                'pageTitle'=>'Forgot Password',
                'validation'=>$this->validator
            ]);
        }else{
            $user=new User();
            $user_info=$user->asObject()->where('email',$this->request->getVar('email'))->first();
            $token=bin2hex(openssl_random_pseudo_bytes(65));
            $password_reset_token= new PasswordResetToken();
            $isOldTokenExists=$password_reset_token->asObject()->where('email',$user_info->email)->first();
            if($isOldTokenExists){
                $password_reset_token->where('email',$user_info->email)
                                     ->set(['token'=>$token,'created_at'=>Carbon::now()])
                                        ->update();
            }else{
                $password_reset_token->insert([
                    'email'=>$user_info->email,
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
            }
            $actionLink=base_url(route_to('admin.reset-password',$token));

            $mailData=array(
                'actionLink'=>$actionLink,
                'user'=>$user_info,

            );
            $view=\Config\Services::renderer();

            $mail_body=$view->setVar('maildata',$mailData)
                ->render('email-templates/forgot-email-template');
            $mailConfig=array(
              'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
              'mail_from_name'=>env('EMAIL_FROM_NAME'),
              'mail_recipient_email'=>$user_info->email,
              'mail_recipient_name'=>$user_info->name,
              'mail_subject'=>'Reset Password',
              'mail_body'=>$mail_body
            );

            if(sendEmail($mailConfig)){
                return redirect()->route('admin.forgot.form')
                    ->with('success','We Have Emailed You With Reset Link');

            }else{
                return redirect()->route('admin.forgot.form')->with('fail','something went wrong');
            }
        }

    }

    public function resetPassword($token){
        $passwordResetPassword=new PasswordResetToken();
        $check_token=$passwordResetPassword->asObject()->where('token',$token)->first();
        if(!$check_token){
            return redirect()->route('admin.forgot.form')
                ->with('fail','Invalid Token');
        }else{
            $difMins=Carbon::createFromFormat('Y-m-d H:i:s',$check_token->created_at)
                ->diffInMinutes(Carbon::now());
            if ($difMins>15){
                return redirect()->route('admin.forgot.form')
                        ->with('fail','Token Expired .. Request another one ');
            }else{
                return view('backend/pages/auth/reset',[
                    'pageTitle'=>'ResetPassword',
                    'validation'=>null,
                    'token'=>$token
                ]);
            }
        }
    }
}
