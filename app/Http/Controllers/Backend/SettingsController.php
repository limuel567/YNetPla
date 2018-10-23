<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Validators;
use App\Models\Configuration;
use App\Models\Admin;
use App\Models\DefaultSetting;

use Auth;

class SettingsController extends Controller{

    function __construct(){
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }
    
    function getIndex()
    {
        $this->data['segment'] = $this->segment;
        $this->data['user'] = Admin::user();
        $this->data['defaults'] = DefaultSetting::find(1);
        return view('backend.settings', $this->data);
    }

    function postGeneral(Request $request)
    {
        // Send all the request to validate
        $validator = Validators::backendValidate($request,"settings_general");
        // Check the validator if there's no error
        if ($validator === true) {
            $config = Configuration::UpdateGeneral($request);
            $admin = User::changeCredentials($request);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postSocial(Request $request)
    {
        // Send all the request to validate
        // $validator = Validators::backendValidate($request,"settings_social");
        // Check the validator if there's no error
        // if($validator === true){
            Configuration::UpdateSocialLinks($request);
            return response()->json(["result" => 'success']);
        // }
        // return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postFilestack(Request $request)
    {
        Configuration::updateFilestackAPI($request);
        return response()->json(["result" => 'success']);
    }

    function postCloudinary(Request $request)
    {
        Configuration::updateCloudinaryAPI($request);
        return response()->json(["result" => 'success']);
    }

    function postDefaultAvatar(Request $request)
    {
        $validator = Validators::backendValidate($request,"settings_avatar");
        if ($validator === true) {
            DefaultSetting::updateDefaultAvatar($request);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postDefaultCover(Request $request)
    {
        $validator = Validators::backendValidate($request,"settings_cover");
        if ($validator === true) {
            DefaultSetting::updateDefaultCover($request);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postEmail(Request $request)
    {
        // Send all the request to validate
        $validator = Validators::backendValidate($request,"configuration_email");
        // Check the validator if there's no error
        if ($validator === true) {
            $admin = User::UpdateEmail($request,Auth::user()->id);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postPassword(Request $request)
    {
        // Send all the request to validate
        $validator = Validators::backendValidate($request,"configuration_password");
        // Check the validator if there's no error
        if ($validator === true) {
            $admin = User::updateCredentials($request,Auth::user()->id);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postApiKeys(Request $request)
    {
        // Send all the request to validate
        $validator = Validators::backendValidate($request,"configuration_api_keys");
        // Check the validator if there's no error
        if ($validator === true) {
            Configuration::updatePaypalAccount($request);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

}