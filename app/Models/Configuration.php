<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\TvMaze;
use App\Models\Helper;

class Configuration extends Model{

    protected $table = 'configurations';

    public static function getFile($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($result, TRUE);
		if (is_array($response) && count($response) > 0 && (!isset($response['status']) || $response['status'] != '404')) {
			return $response;
		}
		
		return false;
    }

    public static function updateGeneral($request)
    {
        $data        = self::find(1);
        $data->name  = $request->website_name;
        $data->email = $request->website_email;
        if($request->hasFile('website_logo')){
            // upload photo to cloudinary
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($data->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($data->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($data->cloudinary_api)['api_secret'] 
            ));
    
            $logo = \Cloudinary\Uploader::upload($request->website_logo, array("public_id" => 'app/'.Helper::seoUrl($request->website_name).'-'.mt_rand(10000000, 99999999)));
            $data->logo = $logo['url'];
        }
        $data->copyright = $request->copyright;
        $data->save();
        return $data;
    }

    public static function updatePageAndCount($page, $count)
    {
        $update = self::find(1);
        $update->last_page = $page;
        $update->last_count = $count;
        $update->save();
    }

    public static function updateTvMaze($request)
    {
        // Get data result
        $shows = self::getFile('https://api.tvmaze.com/show?page='.$request);
        foreach($shows as $key => $show){
            $validator_data = TvMaze::where('id', $show['id'])->first();
            if(!$validator_data){
                $data = new TvMaze;
                $data->id = $show['id'];
				$data->name = $show['name'];
                $data->weight = $show['weight'];
				$data->genre = implode(", ",$show['genres']);
                $data->status = $show['status'];
                $data->serialize = serialize($show);
                $data->save();
            }
        }
        $update_last_count = self::find(1);
        $update_last_count->last_count = count($shows);
		$update_last_count->last_page = $request;
        $update_last_count->save();
    }

    public static function updateTvMazeShow($request)
    {
        // Get data result
        $shows = self::getFile('https://api.tvmaze.com/show?page='.$request);
        foreach($shows as $key => $show){
            $data = TvMaze::where('id', $show['id'])->first();
            if($data){
				$data->name = $show['name'];
                $data->weight = $show['weight'];
				$data->genre = implode(", ",$show['genres']);
                $data->status = $show['status'];
                $data->serialize = serialize($show);
                $data->save();
                return $request;
            }
        }
    }

    public static function updateSocialLinks($request)
    {
        $social_links = [
                            'facebook'    => $request->facebook_link,
                            'twitter'     => $request->twitter_link,
                            'google'      => $request->google_link,
                            'pinterest'   => $request->pinterest_link,
                            'linkedin'    => $request->linkedin_link,
                            'instagram'   => $request->instagram_link,
                        ];
        $data = self::find(1);
        $data->social_media_links = serialize($social_links);
        $data->save();
    }

    public static function updateFilestackAPI($request)
    {
        $filestack = [
                            'api_key'    => $request->api_key,
                        ];
        $data = self::find(1);
        $data->filestack_api = serialize($filestack);
        $data->save();
    }

    public static function updateCloudinaryAPI($request)
    {
        $cloudinary = [
                            'cloud_name'    => $request->cloud_name,
                            'api_key'    => $request->api_key,
                            'api_secret'    => $request->api_secret,
                        ];
        $data = self::find(1);
        $data->cloudinary_api = serialize($cloudinary);
        $data->save();
    }

    public static function updatePaypalAccount($request)
    {
        $paypal_account = [
                            'paypal_test_username'  => $request->paypal_test_username,
                            'paypal_test_password'  => $request->paypal_test_password,
                            'paypal_test_signature' => $request->paypal_test_signature,
                            'paypal_live_username'  => $request->paypal_live_username,
                            'paypal_live_password'  => $request->paypal_live_password,
                            'paypal_live_signature' => $request->paypal_live_signature,
                            'paypal_mode'           => $request->paypal_mode
                        ];
        $data = self::find(1);
        $data->paypal_account = serialize($paypal_account);
        $data->save();
    }

}