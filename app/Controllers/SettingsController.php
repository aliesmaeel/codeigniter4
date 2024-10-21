<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingsController extends BaseController
{
    protected $helpers=['session_helper','url','form','email_helper'];
    public function settings()
    {

        return view('backend/pages/settings', ['pageTitle' => 'Settings', 'validation' => null]);

    }
}
