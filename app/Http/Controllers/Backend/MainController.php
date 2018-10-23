<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Validators;
use App\Models\Helper;
use App\Models\Admin;
use App\Models\Configuration;

use Session;
use Redirect;

use App\User;

class MainController extends Controller{


    function __construct(){
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }

    function getIndex(){
        // Check if admin is authenticated
        $data['segment'] = $this->segment;
        if(Admin::check()){
            return view('backend.dashboard', $data);
        }
        return view('backend.login', $data);
    }

    function getForgotPassword(){
        // Check if admin is authenticated
        $data['segment'] = $this->segment;
        if(Admin::check()){
            return view('backend.dashboard', $data);
        }
        return view('backend.forgot-password', $data);
    }

    function postForgotPassword(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"forgot_password");
        // Check if there is no error
        if($validator === true){
            $check = Admin::forgotPassword($request);
            if($check){
                return response()->json(['result' => 'success']);
            }
            else{
                return response()->json(["result" => 'invalid']);
            }
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postLogin(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"login");
        // Check if there is no error
        if($validator === true){
            // Check if email and password doesn't mactch.
            if(Admin::attempt($request->email, $request->password)){
                $uri = '';
                if($request->has('uri')){
                    $uri = $request->uri;
                }
                return response()->json(['result' => 'success', 'uri' => $uri]);
            }else{
                return response()->json(["result" => 'invalid']);
            }
        }return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function getLogout(){
        // Destroy admin session
        Admin::logout();
        return redirect('admin');
    }

    function getResetPassword(Request $request){
        $data['segment'] = $this->segment;
        if($request->email != NULL){
            $data['reset_id'] = $request->email;
            return view('backend.reset-password', $data);
        }
        return view('errors.500');
    }

    function postResetPassword(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request, "reset_password");
        // Check if there is no error
        if($validator === true){
            // Change password
            $check = Admin::resetPassword($request);
            // Check if exist
            if($check){
                return response()->json(['result' => 'success']);
            }
            else{
                return response()->json(['result' => 'invalid']);
            }
        }return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

}