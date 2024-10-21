<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\User;
use App\Services\EmailService;
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

    public function updateProfilePicture(){
        $request=\Config\Services::request();
        $user_id=SessionAuth::id();
        $user=new User();

        $user_info=$user->asObject()->where('id',$user_id)->first();

        $path='images/users/';
        $file=$request->getFile('user_profile_file');
        $old_picture=$user_info->picture;
        $new_filename='IIMG_'.$user_id.$file->getRandomName();

//        if($file->move($path,$new_filename)){
//            if($old_picture !==null && file_exists($path.$old_picture)){
//                unlink($path.$old_picture);
//            }
//            $user->where('id',$user_id)->set(['picture'=>$new_filename])->update();
//            echo json_encode(['status'=>1,'msg'=>'Successfully updated the image']);
//        }else{
//            echo json_encode(['status'=>0,'msg'=>'Something Went Wrong']);
//        }

        $upload_image=\Config\Services::image()->withFile($file)
            ->resize(450,450,true,'height')
            ->save($path.$new_filename);
        if ($upload_image){
            if($old_picture !==null && file_exists($path.$old_picture)){
               unlink($path.$old_picture);
            }
            $user->where('id',$user_id)->set(['picture'=>$new_filename])->update();
            echo json_encode(['status'=>1,'msg'=>'Successfully updated the image']);
        }else{
            echo json_encode(['status'=>0,'msg'=>'Something Went Wrong']);
        }
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

    public function changePassword(){
        $request=\Config\Services::request();
        if ($request->isAJAX()){
            $validation=\Config\Services::validation();
            $user_id=SessionAuth::id();
            $user=new User();
            $user_info=$user->asObject()->where('id',$user_id)->first();


            $this->validate(AuthValidation::getChangePasswordRules());

            if ($validation->run()==false){
                $errors=$validation->getErrors();

                return json_encode(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                $user->where('id',$user_id)->set(
                    ['password'=>Hash::make($request->getVar('new_password'))]
                )->update();

                $mailData = ['user' => $user, 'new_password' => $request->getVar('new_password')];

                $sendEmail=EmailService::sendEmail([
                    'mailData' => $mailData,
                    'recipient_email' => $user->email,
                    'recipient_name' => $user->name,
                    'subject' => 'Your password has been changed',
                    'template' => 'email-templates/password-changed-email-template'
                ]);
                    if ($sendEmail=true)
                        return json_encode(
                            ['status'=>1,'token'=>csrf_hash(),'msg'=>'Password Updated Successfully']
                        );

                    return json_encode(['status'=>0,'token'=>csrf_hash(),'msg'=>'email was not send']);

                }

        }
    }
}
