<?php

use App\Models\Setting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use MailSlurp\Configuration;
use MailSlurp\Apis\InboxControllerApi;

// app/Helpers/file_helper.php

if (!function_exists('storeImage')) {
    function storeImage($path, $file, $model, $id, $field_name, $prefix, $old_file_name = null)
    {
        $new_file_name = $prefix . $file->getRandomName();

        if ($file->move($path, $new_file_name)) {
            if ($old_file_name != null && file_exists($path . '/' . $old_file_name)) {
                unlink($path . '/' . $old_file_name);
            }

            $update = $model->where('id', $id)
                ->set([$field_name => $new_file_name])
                ->update();

            return $update ? $new_file_name : false;
        }

        return false;
    }
}

