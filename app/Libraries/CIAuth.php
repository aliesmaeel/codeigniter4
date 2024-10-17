<?php
/// store auth admin details in session
namespace App\Libraries;

class CIAuth{
    public static function  setCIAuth($result) : void {
        $session=session();
        $array=['logged_in'=>true];
        $userdata=$result;
        $session->set('userdata',$userdata);
        $session->set($array);
    }
    public static function id(){
        $session=session();
        if($session->has('logged_in') && $session->has('userdata'))
                return $session->get('userdata')['id'];

        return  null;
    }

    public static function check(){
        $session=session();
        return $session->has('logged_in');
    }

    public static function forget(){
        $session=session();
        $session->remove('logged_in');
        $session->remove('userdata');
    }

    public static function user(){
        $session=session();
        if($session->has('logged_in') && $session->has('userdata'))
            return $session->get('userdata');
        return null;

    }
}