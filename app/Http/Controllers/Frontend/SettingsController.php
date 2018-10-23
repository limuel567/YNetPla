<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Validators;
use App\User;
use Auth, Crypt;

class SettingsController extends Controller {
   
    function getIndex()
    {
        return view('frontend.settings.index');
    }

    function getSocialSettings()
    {
        return view('frontend.settings.social');
    }

    function getNotificationSettings()
    {
        return view('frontend.settings.notification');
    }

    function postSave(Request $request)
    {
        // Send all the request to validate
        $validator = Validators::frontendValidate($request,"account_settings");
        // Check the validator if there's no error
        if ($validator === true) {
            $user = User::manageAccount($request, Auth::user()->id);
            $url = URL($user->username.'/photos');
            $urlv2 = URL($user->username.'/loves');
            return response()->json(["result" => 'success', 'uname' => $user->username, 'url' => $url, 'urlv2' => $urlv2]);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }

    function postChangePassword(Request $request)
    {
        // Send all the request to validate
        $validator = Validators::frontendValidate($request,"change_password");
        // Check the validator if there's no error
        if ($validator === true) {
            User::changePassword($request, Auth::user()->id);
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed', "errors" => $validator->errors()->messages()]);
    }
    
    function getLoveDisable(Request $request)
    {
        User::disableLoveNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getLoveEnable(Request $request)
    {
        User::enableLoveNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getCommentDisable(Request $request)
    {
        User::disableCommentNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getCommentEnable(Request $request)
    {
        User::enableCommentNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getFollowDisable(Request $request)
    {
        User::disableFollowNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getFollowEnable(Request $request)
    {
        User::enableFollowNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getVoteDisable(Request $request)
    {
        User::disableVoteNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }
    
    function getVoteEnable(Request $request)
    {
        User::enableVoteNotification(Auth::user()->id);
        return response()->json(["result" => 'success']);
    }

}