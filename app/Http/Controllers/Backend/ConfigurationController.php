<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Validators;
use App\Models\Helper;
use App\Models\Configuration;
use App\Models\Admin;

use Session;

class ConfigurationController extends Controller{

    function getIndex(){
        $data['configuration'] = Configuration::find(1);
        $data['user']          = Admin::user();
        dd($data);
    }

    function postGeneral(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_general");
        // Check if there is no error
        if($validator === true){
            // Update general
            Configuration::UpdateGeneral($request);
            //Update Admin
            $admin = Admin::updateData($request);
            Helper::flashMessage('Good job!','Account has been updated.','success');
            // Destroy session
            Session::forget('admin_session');
            // Put new session
            Session::put('admin_session',$admin);
        }
        return back()->withErrors($validator)->withInput();
    }

    function postSocialLinks(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_social_links");
        // Check if there is no error
        if($validator === true){
            // Update social links
            Configuration::UpdateSocialLinks($request);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postEmail(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_email");
        // Check if there's an error
        if($validator === true){
            // Update general
            $admin = Admin::UpdateEmail($request);
            // Destroy session
            Session::forget('admin_session');
            // Put new session
            Session::put('admin_session',$admin);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postPassword(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_password");
        // Check if there's an error
        if($validator === true){
            // Update general
            $admin = Admin::UpdatePassword($request);
            // Destroy session
            Session::forget('admin_session');
            // Put new session
            Session::put('admin_session',$admin);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postOtherCharges(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_other_charges");
        // Check if there's an error
        if($validator === true){
            // Update lite plan
            Configuration::updateOtherCharges($request);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postLitePlan(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_lite_plan");
        // Check if there's an error
        if($validator === true){
            // Update lite plan
            Configuration::UpdateSubscription($request,'lite');
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postProfessionalPlan(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_professional_plan");
        // Check if there's an error
        if($validator === true){
            // Update professional plan
            Configuration::UpdateSubscription($request,'professional');
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postElitePlan(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_elite_plan");
        // Check if there's an error
        if($validator === true){
            // Update elite plan
            Configuration::UpdateSubscription($request,'elite');
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postApiKeys(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"configuration_api_keys");
        // Check if there's an error
        if($validator === true){
            // Update stripe account
            Configuration::UpdateStripeAccount($request);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

}