<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

use App\User;
use App\Models\Validators;
use App\Models\Helper;
use App\Models\Admin;
use App\Models\Photo;
use App\Models\Follow;

use Mail;
use DB;
use Crypt;

class UsersManagementController extends Controller{

    function __construct(){
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }
    
    function getIndex(Request $request){
        // Get the users
        $this->data['segment'] = $this->segment;
        $this->data['users'] = User::where('id','!=',1)
                                    ->where('id','!=', Admin::user()->id)
                                    ->orderBy('full_name','asc')
                                    ->paginate(8);
        // Get the total users
    	return view('backend.user-management.index',$this->data);
    }

    function getAddNewUser(){
        $this->data['segment'] = $this->segment;
        $data['countries'] = DB::table('countries')->orderBy('Name','asc')->get();
        $data['label']     = 'Add';
        return view('backend.user-management.manage',$data);
    }

    function getEditUser($id){
        $this->data['segment'] = $this->segment;
        $data['user']      = User::find(Crypt::decrypt($id));
        $data['countries'] = DB::table('countries')->orderBy('Name','asc')->get();
        $data['label']     = 'Edit';
        return view('backend.user-management.manage',$data);
    }

    function postCreateNewUser(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"users_manage_information");
        // Check if there is no error
        if($validator === true){
            // Update credentials
            $id  = User::createNewUser($request);
            $url = asset('admin/users-management/edit-user/'.$id);
            Helper::flashMessage('Good job!','User has been added.','success');
            return response()->json(["result" => 'success','url' => $url]);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postManageUserGeneral(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"users_manage_general");
        // Check if there is no error
        if($validator === true){
            // Update the user data
            $data = User::updateGeneral($request);
            return response()->json([
                                        "result"    => 'success',
                                        'name'      => ucwords($data->first_name.' '.$data->last_name),
                                        'privilege' => $data->status
                                    ]);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postManageSocialMediaLinks(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"users_manage_social_media_links");
        // Check if there is no error
        if($validator === true){
            // Update the user data
            User::updateSocialMediaLinks($request);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function postManageUserCredentials(Request $request){
        // Validation data
        $validator = Validators::backendValidate($request,"users_manage_credentials");
        // Check if there is no error
        if($validator === true){
            // Update the user data
            User::updateCredentials($request);
            return response()->json(["result" => 'success']);
        }
        $errors = self::errors($request->all(),$validator->errors());
        return response()->json(["result" => 'failed', "errors" => $errors]);
    }

    function getRemoveUser($id){
        // Get user data
        $user_data = User::find(Crypt::decrypt($id));
        // Check user data if exist
        if(count($user_data)){
            // Delete the user
            User::deleteData(Crypt::decrypt($id));
            Helper::flashMessage('Good job!','The user has been removed.','success');
            return response()->json(["result" => 'success']);
        }
        return response()->json(["result" => 'failed']);
    }

    function getView($slug)
    {
        $this->data['segment'] = $this->segment;
        $data['user'] = User::where('username', $slug)->first();
        $data['photos'] = Photo::where('user_id', $data['user']->id)->latest()->get();
        $data['followers'] = Follow::where('following_user_id', $data['user']->id)->get();
        $data['following'] = Follow::where('user_id', $data['user']->id)->get();
        return view('backend.user-management.view', $data);
    }

}