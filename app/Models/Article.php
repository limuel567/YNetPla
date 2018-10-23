<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Helper;
use App\Models\Configuration;
use Carbon\Carbon;
use Session;
use Crypt, Auth;

class Article extends Model{

    protected $table = 'articles';

    public static function createArticle($request)
    {
        $config = Configuration::find(1);
        $data = new self;
        if($request->hasFile('image')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($config->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($config->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($config->cloudinary_api)['api_secret'] 
            ));
    
            $image = \Cloudinary\Uploader::upload($request->image, array("public_id" => 'articles/poster/'.Helper::seoUrl($config->name).'-'.$request->name.'-'.mt_rand(10000000, 99999999)));
            $data->image = $image['url'];
        }
        if($request->hasFile('signature')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($config->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($config->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($config->cloudinary_api)['api_secret'] 
            ));
    
            $signature = \Cloudinary\Uploader::upload($request->signature, array("public_id" => 'articles/signature/'.Helper::seoUrl($config->name).'-'.$request->name.'-'.mt_rand(10000000, 99999999)));
            $data->signature = $signature['url'];
        }
        $data->name = $request->name;
        $data->author = $request->author;
        $data->show_author = $request->show_author;
        $data->description = serialize(str_replace('"', "'", $request->description));
        $data->save();
        return $data;
    }

    public static function updateArticle($request)
    {
        $config = Configuration::find(1);
        $data = self::find(Crypt::decrypt($request->id));
        if($request->hasFile('image')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($config->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($config->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($config->cloudinary_api)['api_secret'] 
            ));
    
            $image = \Cloudinary\Uploader::upload($request->image, array("public_id" => 'articles/poster/'.Helper::seoUrl($config->name).'-'.$request->name.'-'.mt_rand(10000000, 99999999)));
            $data->image = $image['url'];
        }
        if($request->hasFile('signature')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($config->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($config->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($config->cloudinary_api)['api_secret'] 
            ));
    
            $signature = \Cloudinary\Uploader::upload($request->signature, array("public_id" => 'articles/signature/'.Helper::seoUrl($config->name).'-'.$request->name.'-'.mt_rand(10000000, 99999999)));
            $data->signature = $signature['url'];
        }
        $data->name = $request->name;
        $data->author = $request->author;
        $data->show_author = $request->show_author;
        $data->description = serialize(str_replace('"', "'", $request->description));
        $data->save();
        return $data;
    }
}