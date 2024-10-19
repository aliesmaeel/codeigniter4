<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Carbon\Carbon;
use App\Libraries\SessionAuth;
use App\Libraries\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;
use App\Services\EmailService;
use App\Validation\AuthValidation;

class AuthController extends BaseController
{
    protected $helpers = ['session_helper','url','form','email_helper'];

    public function loginForm()
    {


        return view('backend/pages/auth/login', ['pageTitle' => 'Login', 'validation' => null]);
    }

    public function loginHandler()
    {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $isValid = $this->validate(AuthValidation::getLoginRules($fieldType));

        if (!$isValid) {
            return view('backend/pages/auth/login', [
                'pageTitle' => 'Login',
                'validation' => $this->validator
            ]);
        }

        $user = new User();
        $userInfo = $user->where($fieldType, $this->request->getVar('login_id'))->first();
        $checkPassword = Hash::check($this->request->getVar('password'), $userInfo['password']);

        if (!$checkPassword) {
            return redirect()->route('admin.login.form')->with('fail', 'Wrong Password')->withInput();
        }

        SessionAuth::setAuth($userInfo);
        return redirect()->route('admin.home');
    }

    public function forgotForm()
    {
        return view('backend/pages/auth/forgot', ['pageTitle' => 'Forgot Password', 'validation' => null]);
    }

    public function sendPasswordResetLink()
    {
        $isValid = $this->validate(['email' => 'required|valid_email|is_not_unique[users.email]']);

        if (!$isValid) {
            return view('backend/pages/auth/forgot', [
                'pageTitle' => 'Forgot Password',
                'validation' => $this->validator
            ]);
        }

        $user = (new User())->asObject()->where('email', $this->request->getVar('email'))->first();
        $token = bin2hex(openssl_random_pseudo_bytes(65));

        $this->storeResetToken($user->email, $token);

        $mailData = [
            'actionLink' => base_url(route_to('admin.reset-password', $token)),
            'user' => $user
        ];

        EmailService::sendEmail([
            'mailData' => $mailData,
            'recipient_email' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Reset Password',
            'template' => 'email-templates/forgot-email-template'
        ]);

        return redirect()->route('admin.forgot.form')->with('success', 'We have emailed you a reset link');
    }

    protected function storeResetToken($email, $token)
    {
        $passwordResetToken = new PasswordResetToken();
        $isOldTokenExists = $passwordResetToken->asObject()->where('email', $email)->first();

        $data = ['token' => $token, 'created_at' => Carbon::now()];

        if ($isOldTokenExists) {
            $passwordResetToken->where('email', $email)->set($data)->update();
        } else {
            $passwordResetToken->insert(array_merge($data, ['email' => $email]));
        }
    }

    public function resetPassword($token)
    {
        $passwordResetToken = new PasswordResetToken();
        $tokenData = $passwordResetToken->asObject()->where('token', $token)->first();

        if (!$tokenData || $this->isTokenExpired($tokenData->created_at)) {
            return redirect()->route('admin.forgot.form')->with('fail', 'Token expired. Request another one.');
        }

        return view('backend/pages/auth/reset', [
            'pageTitle' => 'Reset Password',
            'validation' => null,
            'token' => $token
        ]);
    }

    protected function isTokenExpired($createdAt)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->diffInMinutes(Carbon::now()) > 15;
    }

    public function resetPasswordHandler($token)
    {
        $isValid = $this->validate(AuthValidation::getPasswordResetRules());

        if (!$isValid) {
            return view('backend/pages/auth/reset', [
                'pageTitle' => 'Reset Password',
                'validation' => $this->validator,
                'token' => $token
            ]);
        }

        $passwordResetToken = new PasswordResetToken();
        $tokenData = $passwordResetToken->asObject()->where('token', $token)->first();
        $user = (new User())->asObject()->where('email', $tokenData->email)->first();

        $this->updateUserPassword($user->email, $this->request->getVar('new_password'));

        $mailData = ['user' => $user, 'new_password' => $this->request->getVar('new_password')];

        EmailService::sendEmail([
            'mailData' => $mailData,
            'recipient_email' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Your password has been changed',
            'template' => 'email-templates/password-changed-email-template'
        ]);

        $passwordResetToken->where('email', $user->email)->delete();

        return redirect()->route('admin.login.form')->with('success', 'Your password has been changed successfully');
    }

    protected function updateUserPassword($email, $newPassword)
    {
        (new User())->where('email', $email)->set(['password' => Hash::make($newPassword)])->update();
    }
}
