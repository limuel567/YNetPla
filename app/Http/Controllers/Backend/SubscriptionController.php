<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Validators;
use Carbon\Carbon;
use Crypt, Session;

class SubscriptionController extends Controller {
    
    function __construct(){
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }

    function getIndex()
    {   
        $data['segment'] = $this->segment;
        $data['subscription'] = Subscription::get();
        return view('backend.challenges.index', $data);
    }

    function getCreate()
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Add';
        return view('backend.challenges.create', $data);
    }

    function getEdit(Request $request,$id)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Edit';
        $data['subscription'] = Subscription::find(Crypt::decrypt($id));
        $data['description'] = unserialize($data['subscription']->description);
        return view('backend.challenges.create', $data);
    }

    function getUpdate($id)
    {
        $data['challenge'] = Challenge::find(Crypt::decrypt($id));
        if (!empty($data['challenge'])) {
            $data['segment'] = $this->segment;
            $data['label'] = 'Edit';
            return view('backend.challenges.create', $data);
        } return back();
    }

    function postCreate(Request $request)
    {
        $validator = Validators::frontendValidate($request, "create_challenge");
        // Check the validator if there's no error
        if ($validator === true) {
            if($request->id){
                Subscription::updateSubscription($request);
            }else{
                Subscription::createSubscription($request, true);
            }
            return response()->json(["result" => "success"]);
        }
        return response()->json(["result" => "failed", "errors" => $validator->errors()->messages()]);
    }
}