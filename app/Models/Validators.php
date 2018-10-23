<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Gallery;
use App\Models\Categories;

use Validator;
use Session;
use Crypt;
use Auth;

class Validators extends Model{

    public static function frontendValidate($request,$key)
    {
        $rules = [];
        switch($key) {
            case 'reset_password':
                $rules = [
                    'password'              => 'required|min:3|confirmed',
                    'password_confirmation' => 'required|min:3',
                    'id'                    => 'required'
                ];
                break;
            case 'signup';
                $rules = [];
                $rules['email'] = 'required|email|unique:users,email';
                $rules['password'] = 'required|min:6';
                break;
            case 'signup-additional';
                $rules = [];
                // $rules['username'] = 'required|alpha_dash|unique:users,username';
                $rules['full_name'] = 'required';
                $rules['company_name'] = 'required';
                break;
            case 'login';
                $rules = [];
                $rules['email']    = 'required|email|exists:users,email';
                $rules['password'] = 'required|min:6';
                break;
            case 'create_challenge';
                $rules = [];
                $rules['name'] = 'required|regex:/([A-Za-z0-9 ])+/';
                $rules['subscription_type'] = 'required';
                $rules['subscription_period'] = 'numeric|min:1';
                break;
            case 'account_settings';
                $rules = [];
                if(Auth::user()->username != $request->username){
                    $rules['username'] = 'string|min:3|unique:users,username|regex:/^[a-zA-Z0-9.]*$/';
                }
                if(Auth::user()->email != $request->email){
                    $rules['email']    = 'required|email|unique:users,email';
                }
                $rules['bio']  = 'max:250';
                if($request->link != null){
                    $rules['link']  = 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
                }
                $rules['profile_photo']  = 'file|mimes:jpeg,png';
                $rules['cover_photo']  = 'file|mimes:jpeg,png';
                break;
            case 'change_password';
                $rules = [];
                $rules['old_password']      = 'required|min:6|in:'.Crypt::decrypt(Auth::user()->crypted_password);
                $rules['password']      = 'required|min:6|confirmed|different:old_password';
                $rules['password_confirmation']  = 'required|min:6';
                break;
            case 'my_galleries_general';
                $gallery_data = Gallery::find(Crypt::decrypt($request->id));
                $rules = [];
                $rules['name'] = 'required';
                if ($gallery_data->url != $request->url) {
                    $rules['url'] = 'required|unique:gallery,url|regex:/^[a-zA-Z0-9-\s]+$/';
                }
                $rules['event_date']  = 'required|date_format:Y-m-d';
                //$rules['description'] = 'required';
                break;
            case 'rename_collection':
                $rules = [
                    'name_collection' => 'required|max:25|unique:collections,collection_name'
                ];
                break;
            case 'forgot_password':
                $rules = [
                    'email' => 'required|email|exists:users,email',
                ];
                break;
            case 'client_password':
                $rules = [
                    'client_password' => 'min:3',
                ];
                break;
            case 'visitor_password':
                $rules = [
                    'visitor_password' => 'min:3',
                ];
                break;
            case 'add_collection':
                $rules = [
                    'collection_name' => 'required|max:50'
                ];
                break;
            case 'send_via_email':
                $rules = [
                    'email_receiver' => 'required|email',
                    'email_subject' => 'required|max:100',
                    'email_body' => 'required|max:250'
                ];
                break;
            case 'share_via_email':
                $rules = [
                    'email_receiver' => 'required|email',
                    'email_subject' => 'required|max:100',
                    'email_body' => 'required|max:250'
                ];
                break;
            case 'edit_profile';
                $rules = [];
                $rules['first_name'] = 'required';
                $rules['last_name']  = 'required';
                if ($request->has('current_password') || $request->has('password') || $request->has('password_confirmation')) {
                    $rules['current_password']      = 'required|min:3|in:'.Crypt::decrypt(Auth::user()->crypted_password);
                    $rules['password']              = 'required|min:3|confirmed';
                    $rules['password_confirmation'] = 'required|min:3';
                }
                /* $rules['street']       = 'required';
                $rules['city']         = 'required';
                $rules['zip_code']     = 'required';
                $rules['country']      = 'required|not_in:default';
                $rules['phone_number'] = 'required'; */
                break;
        }
    	$validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Check if the request is not an ajax
            if (!$request->ajax()) {
                Session::flash('session_header','Action failed');
                Session::flash('session_content','Please check your inputs or connection and try again.');
                Session::flash('session_boolean','error');
            } return $validator;
    	} return true;
    }
    
    public static function backendValidate($request,$key)
    {
        switch ($key) {
            case 'users_manage_information';
                $rules = [];
                $rules['privilege']  = 'required|in:0,1';
                if ($request->privilege != 0) {
                    $rules['first_name'] = 'required|string';
                    $rules['last_name']  = 'required|string';
                    $rules['username']   = 'required|string|unique:users,username|regex:/^[a-zA-Z0-9.]*$/';
                }
                $rules['email']    = 'required|email|unique:users,email';
                $rules['password'] = 'required|min:3';
                break;
            case 'users_manage_general';
                $rules = [];
                $rules['privilege'] = 'required|in:0,1';
                if ($request->privilege != 0) {
                    $rules['first_name'] = 'required|string';
                    $rules['last_name']  = 'required|string';
                    $user_data = User::where('id',Crypt::decrypt($request->id))
                                        ->where('username',$request->username)
                                        ->count();
                    if ($user_data == 0) {
                        $rules['username'] = 'required|string|unique:users,username|regex:/^[a-zA-Z0-9.]*$/';
                    }
                }
                break;
            case 'users_manage_credentials';
                $rules = [];
                $user = User::find(Crypt::decrypt($request->id));
                if ($user->email != $request->email) {
                    $rules['email'] = "required|email|unique:users,email";
                }
                $rules['password'] = "required|min:3";
                break;
            case 'reset_password':
                $rules = [
                    'new_password'              => 'required|min:3|confirmed',
                    'new_password_confirmation' => 'required|min:3',
                    'id'                    => 'required'
                ];
                break;
            case 'products_save';
                $rules = [];
                if (!$request->has('categories')) {
                    $rules['category'] = 'required';
                }
                $rules['name']        = 'required|string';
                $rules['description'] = 'required|string|not_in:<p><br></p>';
                $rules['price']       = 'required|numeric';
                $rules['picture']     = 'image';
                break;
            case 'plans_save':
                $rules = [
                    'name'              => 'required|min:3',
                    'storage_limit'     => 'required',
                    'gallery_limit'     => 'required',
                    'max_resolution'    => 'required'
                ];
                break;
            case 'events_save':
                $rules = [
                    'name'              => 'required|min:3',
                ];
                break;
            case 'announcement_save':
                $rules = [
                    'title'              => 'required',
                    'announcement'       => 'required',
                    'button_text'        => 'required',
                    'button_url'         => 'required',
                ];
                break;
            case 'login':
                $rules = [
                    'email'    => 'required|email|exists:users,email',
                    'password' => 'required|min:3'
                ];
                break;
            case 'forgot_password':
                $rules = [
                    'email' => 'required|email|exists:users,email',
                ];
                break;
            case 'settings_social':
                $rules = [];
                if ($request->has('facebook_link')) {
                    $rules['facebook_link'] = "url";
                }
                if ($request->has('instagram_link')) {
                    $rules['instagram_link'] = "url";
                }
                if ($request->has('twitter_link')) {
                    $rules['twitter_link'] = "url";
                }
                break;
            case 'configuration_password':
                $rules = [
                    'current_password'      => 'required|min:3|in:'.Crypt::decrypt(Auth::user()->crypted_password),
                    'password'              => 'required|min:3|confirmed',
                    'password_confirmation' => 'required|min:3'
                ];
                break;
            case 'settings_general':
                $rules = [
                    'website_logo'    => 'image',
                    'website_name'    => 'required',
                    'website_email'   => 'required|email',
                    'copyright'       => 'required'
                ];
                break;
            case 'settings_avatar':
                $rules = [
                    'avatar'       => 'required|image'
                ];
                break;
            case 'create_article':
                $rules = [
                    'name'        => 'required|string',
                    'author'      => 'required|string',
                    'show_author' => 'required|integer',
                    'description' => 'required|string',
                    'image'       => 'required|image'
                ];
                break;
            case 'settings_cover':
                $rules = [
                    'cover'       => 'required|image'
                ];
                break;
            case 'configuration_email':
                $rules = [
                    'current_email'      => 'required|email|in:'.Auth::user()->email,
                    'email'              => 'required|email|unique:users,email|confirmed',
                    'email_confirmation' => 'required|email|unique:users,email'
                ];
                break;
            case 'configuration_api_keys':
                $rules = [
                    'paypal_test_username'  => 'required_with:paypal_test_password,paypal_test_signature',
                    'paypal_test_password'  => 'required_with:paypal_test_username,paypal_test_signature',
                    'paypal_test_signature' => 'required_with:paypal_test_username,paypal_test_password',
                    'paypal_live_username'  => 'required_with:paypal_live_password,paypal_live_signature',
                    'paypal_live_password'  => 'required_with:paypal_live_username,paypal_live_signature',
                    'paypal_live_signature' => 'required_with:paypal_live_username,paypal_live_password',
                    'paypal_mode'           => 'required|in:live,sandbox'
                ];
                break;
            case 'cms_custom_add';
                $rules = [];
                $rules['page_dropdown'] = 'required';
                if ($request->page_dropdown == 'custom_page') {
                   $rules['page_name'] = 'required|unique:pages,name'; 
                }
                $rules['section']    = 'required';
                $rules['field_type'] = 'required';
                $rules['field_name'] = 'required';
                if ($request->has('repeater_field_type')) {
                   $rules['repeater_field_type.*'] = 'required|regex:/^[a-zA-Z0-9_ ]*$/';
                   $rules['repeater_field_name.*'] = 'required|regex:/^[a-zA-Z0-9_ ]*$/';
                }
                break;
            case 'categories_save';
                $rules = [];
                if ($request->has('id')) {
                    $category = Categories::find(Crypt::decrypt($request->id));
                    if ($category->name == $request->name && $category->status == $request->status) {
                        $rules['name'] = 'required';
                    }
                } else {
                    $rules['name'] = 'required|unique:categories,name';
                }
                $rules['status'] = 'required|in:0,1';
                break;
            case 'blog_save';
                $rules = [];
                if (!$request->has('categories')) {
                    $rules['category'] = 'required';
                }
                $rules['title']       = 'required|string';
                $rules['description'] = 'required|string|not_in:<p><br></p>';
                break;
            case 'edit_payment':
                $rules = [
                    'card_number'    => 'required|integer|min:19',
                    'cvc'            => 'required|integer'
                ];
                break;
            case 'edit_billing':
                $rules = [
                    'first_name'    => 'required|string',
                    'last_name'     => 'required|string',
                    'street'        => 'required|string',
                    'city'          => 'string',
                    'zip_code'      => 'required|regex:/\b\d{5}\b/',
                    'country'       => 'required|string',
                    'phone_number'  => 'required|regex:/(01)[0-9]{9}/'
                ];
                break;
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Check if the request is not an ajax
            if (!$request->ajax()) {
                Session::flash('session_header','Action failed');
                Session::flash('session_content','Please check your inputs or connection and try again.');
                Session::flash('session_boolean','error');
            } return $validator;
        } return true;
    }

}