<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session, Hash, Crypt, Auth;
use App\Models\DefaultSetting;
use App\Models\Admin;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->type == 0 ? true : false;
    }

    public function challenges()
    {
        return $this->hasMany('App\Models\Challenge');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    }

    public function honors()
    {
        return $this->hasMany('App\Models\Honor');
    }

    public function loves()
    {
        return $this->hasMany('App\Models\Love');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function collections()
    {
        return $this->hasMany('App\Models\Collection');
    }

    public static function manageAccount($request, $id='none')
    {
         // For new user
         if ($id == 0) {
            $username                          = explode("@", $request->email);
            // check if username exists
            $check = self::where('username', $username[0])->count();
            $data = new Self;
            $new_username = '';
            if($check){
                do{
                    $digits = 4;
                    $random_number = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    $new_username = $username[0] . $random_number;
                    $check = self::where('username', $new_username)->count();
                } while ($check > 0);
            }else{
                $new_username                    = $username[0];
            }
        	$data->username                    = $new_username;
        	$data->full_name                   = $new_username;
        	$data->email                       = $request->email;
        	$data->password                    = Hash::make($request->password);
            $data->crypted_password            = Crypt::encrypt($request->password);
            
            $defaults = DefaultSetting::find(1);
            $data->profile_photo               = $defaults->avatar;
        	$data->cover_photo                 = $defaults->cover;
            $data->privilege                   = 1;
            $data->user_type                   = 1;
            $data->status                      = 1; // doesn't need an email verification
            // Check if the authentication is an admin
            if (Auth::check()) {
                if (Auth::user()->privilege == 0) {
                    $data->status = 1;
                }
            }
                
            if (isset($_SERVER['HTTP_CLIENT_IP']))
            {
                $real_ip_adress = $_SERVER['HTTP_CLIENT_IP'];
            }
            
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $real_ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $real_ip_adress = $_SERVER['REMOTE_ADDR'];
            }
            
            $cip = $real_ip_adress;
            $iptolocation = file_get_contents('http://apinotes.com/ipaddress/ip.php?ip='. $cip);
            $creatorlocation = json_decode($iptolocation, TRUE);

            $data->country_name = $creatorlocation['country_name'];
            $data->country_code = $creatorlocation['country_code'];
            $data->country_code3 = $creatorlocation['country_code3'];
            $data->region_code = $creatorlocation['region_code'];
            $data->region_name = $creatorlocation['region_name'];
            $data->city_name = $creatorlocation['city_name'];
            $data->latitude = $creatorlocation['latitude'];
            $data->longitude = $creatorlocation['longitude'];

            $data->save();
        // For updating a user
        } else {
            $data = self::find($id);
            if($request->has('email')){
                $data->email = $request->email;
            }
            if($request->has('full_name')){
                $data->full_name = $request->full_name;
            }
            if($request->has('username')){
                $data->username = $request->username;
            }
            if($request->has('company_name')){
                $data->company_name = $request->company_name;
            }
            if($request->has('bio')){
                $data->bio = $request->bio;
            }
            if($request->has('link')){
                $data->web_link = $request->link;
            }
            $data->save();
        }

        return $data;
    }

    public static function socialAuth($request, $label)
    {
        $data = new Self;
        switch ($label) {
            case 'google':
                $data->google_id = $request->id;
                $data->full_name = $request->user['displayName']; 
                $data->status = 1;
                break;
            case 'facebook':
                $data->facebook_id = $request->id;
                $data->full_name = $request->user['name']; 
                $data->status = 1;
                break;
        }
        $username = explode("@", $request->email);
        // check if username exists
        $check_uname = self::where('username', $username[0])->count();
        $new_username = '';
        if($check_uname){
            do{
                $digits = 4;
                $random_number = rand(pow(10, $digits-1), pow(10, $digits)-1);
                $new_username = $username[0] . $random_number;
                $check_uname = self::where('username', $new_username)->count();
            } while ($check_uname > 0);
        }else{
            $new_username                    = $username[0];
        }
        $email = self::where('email', $request->email)->count();
        if (!$email) {
            $data->email = $request->email;
        }
        $data->username                    = $new_username;
        $data->password                    = Hash::make($request->email);
        $data->crypted_password            = Crypt::encrypt($request->email);
        
        $defaults = DefaultSetting::find(1);
        $data->profile_photo               = $defaults->avatar;
        $data->cover_photo                 = $defaults->cover;
        $data->privilege                   = 1;
        $data->user_type                   = 1;
        // Check if the authentication is an admin
        if (Auth::check()) {
            if (Auth::user()->privilege == 0) {
                $data->status = 1;
            }
        }
            
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $real_ip_adress = $_SERVER['HTTP_CLIENT_IP'];
        }
        
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $real_ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $real_ip_adress = $_SERVER['REMOTE_ADDR'];
        }
        
        $cip = $real_ip_adress;
        $iptolocation = file_get_contents('http://apinotes.com/ipaddress/ip.php?ip='. $cip);
        $creatorlocation = json_decode($iptolocation, TRUE);

        $data->country_name = $creatorlocation['country_name'];
        $data->country_code = $creatorlocation['country_code'];
        $data->country_code3 = $creatorlocation['country_code3'];
        $data->region_code = $creatorlocation['region_code'];
        $data->region_name = $creatorlocation['region_name'];
        $data->city_name = $creatorlocation['city_name'];
        $data->latitude = $creatorlocation['latitude'];
        $data->longitude = $creatorlocation['longitude'];
        $data->save();

        return $data;
    }

    public static function changePassword($request, $id)
    {
        $data = self::find($id);
        $data->password         = Hash::make($request->password);
        $data->crypted_password = Crypt::encrypt($request->password);
        $data->save();
        return true;
    }

    public static function changeCredentials($request)
    {
        Admin::updateEmail($request);
        if($request->new_password){
            Admin::updatePassword($request);
            $email = $request->new_email;
            $password = $request->new_password;
            $attemp = Admin::attempt($email,$password);
        } else {
            $admin = User::where('status',1)->first();
            $email = $request->new_email;
            $admin->email = $email;
            $admin->save();
            Session::put('admin_session', $admin);
        }
        return true;
    }

    public static function disableLoveNotification($id)
    {
        $data = self::find($id);
        $data->love_notification = 0;
        $data->save();
    }

    public static function enableLoveNotification($id)
    {
        $data = self::find($id);
        $data->love_notification = 1;
        $data->save();
    }

    public static function disableCommentNotification($id)
    {
        $data = self::find($id);
        $data->comment_notification = 0;
        $data->save();
    }

    public static function enableCommentNotification($id)
    {
        $data = self::find($id);
        $data->comment_notification = 1;
        $data->save();
    }

    public static function disableFollowNotification($id)
    {
        $data = self::find($id);
        $data->follow_notification = 0;
        $data->save();
    }

    public static function enableFollowNotification($id)
    {
        $data = self::find($id);
        $data->follow_notification = 1;
        $data->save();
    }

    public static function disableVoteNotification($id)
    {
        $data = self::find($id);
        $data->vote_notification = 0;
        $data->save();
    }

    public static function enableVoteNotification($id)
    {
        $data = self::find($id);
        $data->vote_notification = 1;
        $data->save();
    }
}
