<?php

namespace App\Libraries;

class JsonResponse
{
    public static function response($status,$data,$message=null){
        return [
            'status'=>$status,
            'user_info'=>$data,
            'msg'=>$message
        ];
    }
}