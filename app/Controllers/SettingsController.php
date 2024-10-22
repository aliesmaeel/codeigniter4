<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\SessionAuth;
use App\Models\User;
use App\Validation\AuthValidation;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Setting;

class SettingsController extends BaseController
{
    protected $helpers=['session_helper','url','form','email_helper'];
    public function settings()
    {
        return view('backend/pages/settings', ['pageTitle' => 'Settings', 'validation' => null]);
    }

    public function updateGeneralSettings(){
        $request=\Config\Services::request();

        if ($request->isAJAX()){
            $validation=\Config\Services::validation();
            $this->validate(AuthValidation::getSettingsRules());

            if ($validation->run()==false){
                $errors=$validation->getErrors();
                return json_encode(['status'=>0,'token'=>csrf_hash(),'error'=>$errors]);
            }else{
                $settings=new Setting();
                $setting_id=$settings->asObject()->first()->id;
                $update=$settings->where('id',$setting_id)->set([
                    'blog_title'=>$request->getVar('blog_title'),
                    'blog_email'=>$request->getVar('blog_email'),
                    'blog_phone'=>$request->getVar('blog_phone'),
                    'blog_meta_keywords'=>$request->getVar('blog_meta_keywords'),
                    'blog_meta_description'=>$request->getVar('blog_meta_description'),
                ])->update();
                if($update)
                    return json_encode(['status'=>1,'token'=>csrf_hash(),'msg'=>'Settings Updated Successfully ']);
                return json_encode(['status'=>0,'token'=>csrf_hash(),'msg'=>'SomeThing Went Wrong']);
            }
        }
    }

    public function updateBlogLogo(){
        $request=\Config\Services::request();

        if ($request->isAJAX()){
                $settings=new Setting();
                $path='images/blog';
                $file=$request->getFile('blog_logo');
                $setting_data=$settings->asObject()->first();
                $old_blog_logo=$setting_data->blog_logo;
                $new_file_name='Bloglogo'.$file->getRandomName();

                if ($file->move($path,$new_file_name)){
                        if ($old_blog_logo !=null && file_exists($path.$old_blog_logo)){
                            unlink($path.$old_blog_logo);
                        }
                    $update=$settings->where('id',$setting_data->id)
                        ->set(['blog_logo'=>$new_file_name,])
                        ->update();

                    if ($update)
                        return json_encode(['status'=>1,'token'=>csrf_hash(),'msg'=>'Settings Updated Successfully ']);
                }
                    return json_encode(['status'=>0,'token'=>csrf_hash(),'msg'=>'SomeThing Went Wrong']);


            }

    }

    public function updateBlogFavicon(){

        $request=\Config\Services::request();
        if ($request->isAJAX()){
            $settings=new Setting();
            $path='images/blog';
            $file=$request->getFile('blog_favicon');
            $setting_data=$settings->asObject()->first();
            $old_blog_logo=$setting_data->blog_logo;
            $new_file_name='favicon_'.$file->getRandomName();

            if ($file->move($path,$new_file_name)){
                if ($old_blog_logo !=null && file_exists($path.$old_blog_logo)){
                    unlink($path.$old_blog_favicon);
                }
                $update=$settings->where('id',$setting_data->id)
                    ->set(['blog_favicon'=>$new_file_name,])
                    ->update();

                if ($update)
                    return json_encode(['status'=>1,'token'=>csrf_hash(),'msg'=>'Settings Updated Successfully ']);
            }
            return json_encode(['status'=>0,'token'=>csrf_hash(),'msg'=>'SomeThing Went Wrong']);


        }
    }
}
