<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Validation\AuthValidation;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\SessionAuth;
use App\Libraries\JsonResponse;

class AdminController extends BaseController
{


    protected $helpers=['session_helper','url','form','email_helper'];
    public function index()
    {

        $data=[
            'pageTitle'=>'Dashboard',
        ];
        return view('backend/pages/home',$data);
    }

    public function logoutHandler(){
        SessionAuth::logout();
        return redirect()->route('admin.login.form')
            ->with('fail','You are logged out !');
    }

    public function profile(){
        $data=[
            'pageTitle'=>'Profile',
        ];
        return view('backend/pages/profile',$data);
    }

    public function updatePersonalDetails(){

        $request=\Config\Services::request();
        $validation=\Config\Services::validation();
        $user_id=SessionAuth::id();

        if ($request->isAJAX()){
            $this->validate(AuthValidation::getProfileRules());

            if ($validation->run()==false){
                $errors=$validation->getErrors();
                return json_encode(['status'=>0,'error'=>$errors]);
            }else{

                $user=new User();
                $update=$user->where('id',$user_id)
                              ->set(['name'=>$request->getVar('name'),
                                  'username'=>$request->getVar('username'),
                                  'bio'=>$request->getVar('bio')])->update();

                if ($update){
                    $user_info=$user->find($user_id);
                    return json_encode(JsonResponse::response(1,$user_info,'Your Data Updated Successfully'));
                }

                return json_encode(JsonResponse::response(0,'','Something Went Wrong !'));
            }

        }
    }
}
