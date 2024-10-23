<?php

use App\Libraries\SessionAuth;
use App\Models\User;
use App\Models\Setting;
use App\Models\SocialMedia;

if (!function_exists('get_user')){
    function get_user()
    {
        if (SessionAuth::isAuthenticated()){
            $user=new User();
            return $user->asObject()->where('id',SessionAuth::id())->first();
        }else {
            return null;
        }
    }
}

if (!function_exists('get_settings')){
    function get_settings()
    {
        $settings=new Setting();
        $setting_data=$settings->asObject()->first();

        if(!$setting_data)
            return defaultSettings($settings);

        return $setting_data;
    }
}

function defaultSettings($settings){
    $data=[
        'blog_title'=>'Ali blog',
        'blog_email'=>'ali@gmail.com',
        'blog_phone'=>'+49444444',
        'blog_meta_keywords'=>'key words',
        'blog_meta_description'=>'test description',
        'blog_logo'=>'logo',
        'blog_favicon'=>'favicon',
    ];
    $settings->save($data);
    $new_settings_data=$settings->asObject()->first();
    return $new_settings_data;
}


if (!function_exists('get_social_media')){
    function get_social_media()
    {
        $social_media=new SocialMedia();
        $social_media_data=$social_media->asObject()->first();

        if(!$social_media_data)
            return defaultSocialMedia($social_media);

        return $social_media_data;
    }
}

function defaultSocialMedia($social_media){
    $data=[
        'facebook_url'=>'www.facebook.com',
        'instagram_url'=>'www.instagram.com',
        'youtube_url'=>'www.youtube.com',
        'twitter_url'=>'www.twitter.com',
    ];
    $social_media->save($data);
    $new_social_media_data=$social_media->asObject()->first();
    return $new_social_media_data;
}

