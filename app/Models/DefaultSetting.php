<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Configuration;
use Crypt;
use Session;

class DefaultSetting extends Model{

    protected $table = 'default_settings';

    public static function updateDefaultAvatar($request)
    {
        $config = Configuration::find(1);
        $data = self::find(1);
        if($request->hasFile('avatar')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($config->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($config->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($config->cloudinary_api)['api_secret'] 
            ));
    
            $avatar = \Cloudinary\Uploader::upload($request->avatar, array("public_id" => 'defaults/avatar/'.Helper::seoUrl($config->name).'-avatar-default-'.mt_rand(10000000, 99999999)));
            $data->avatar = $avatar['url'];
        }
        $data->save();
        return $data;
    }

    public static function updateDefaultCover($request)
    {
        $config = Configuration::find(1);
        $data = self::find(1);
        if($request->hasFile('cover')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($config->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($config->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($config->cloudinary_api)['api_secret'] 
            ));
    
            $cover = \Cloudinary\Uploader::upload($request->cover, array("public_id" => 'defaults/cover/'.Helper::seoUrl($config->name).'-cover-default-'.mt_rand(10000000, 99999999)));
            $data->cover = $cover['url'];
        }
        $data->save();
        return $data;
    }
}