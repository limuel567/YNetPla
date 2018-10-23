<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\Helper;

use Carbon\Carbon;
use Session;
use Redirect;
use Mail;
use Hash;
use File;
use Crypt;
use DB;

class Admin extends Model{

    protected $table = 'users';

    public static function attempt($email,$password){
        // Get data result
        $result = Admin::where('email',$email)->where('status',1)->first();
        // Check if there is a result
        if($result){
            // Check if password matches
            if(Hash::check($password, $result->password)){
                // Create admin session
                Session::put('admin_session', $result);
                return true;
            }
        }
        return false;
    }

    public static function check(){
        // Check if session is true
        return (Session::get('admin_session')) ? true : false;
    }

    public static function logout(){
        // Destroy session
        Session::forget('admin_session');
        return Redirect::to('/admin/login');
    }

    public static function user(){
        // Get the admin data
        return Session::get('admin_session');
    }

    public static function updateData($request){
        $data             = self::find(self::user()->id);
        $data->first_name = $request->first_name;
        $data->last_name  = $request->last_name;
        if($request->hasFile('profile_picture')){
            // Upload files holds old file, field name, request, first folder and second folder
            $data->profile_picture = Helper::uploadFile($data->profile_picture,'profile_picture',$request,'profile_picture',self::user()->id);
        }
        $data->save();
        return $data;
    }

    public static function updateEmail($request){
        $data        = self::find(self::user()->id);
        $data->email = $request->new_email;
        $data->save();
        return $data;
    }

    public static function updatePassword($request){
        $data                   = self::find(self::user()->id);
        $data->password         = Hash::make($request->new_password);
        $data->crypted_password = Crypt::encrypt($request->new_password);
        $data->save();
        return $data;
    }

    public static function forgotPassword($request){
        // get data
        $data = self::where('email', $request->email)->first();
        // Check if data exist
        if($data){
            // get admin data
            $configuration = configuration::find(1);    
            $token = session()->get('_token');
            DB::table('password_resets')->insert([
                'email'      => $request->email,
                'token'      => $token,
                'created_at' => Carbon::now()
            ]);    
            // Send password reset link.
            Mail::send('emails.forgot-password', array('token' => $token, 'user' => $data, 'configuration' => $configuration),
                function($message) use ($data, $configuration){
                $message->to($data->email)->subject($configuration->name.': Forgot Password');
                $message->from($configuration->email, $configuration->name.' Management');
            });
            return true;
        }
        return false;
    }

    public static function resetPassword($request){
        $data = self::find(Crypt::decrypt($request->id));
        if($data){
            $data->password         = Hash::make($request->new_password);
            $data->crypted_password = Crypt::encrypt($request->new_password);
            $data->save();
            return true;
        }
        return false;
    }

}