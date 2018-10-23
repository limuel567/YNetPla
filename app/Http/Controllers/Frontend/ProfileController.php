<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Photo;
use App\Models\Honor;
use App\Models\Entry;
use App\Models\Comment;
use App\Models\Collection;
use App\Models\Love;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\Configuration;
use App\Models\Achievement;
use App\User;
use Auth, Crypt, Mail;

class ProfileController extends Controller {
   
    function getIndex($slug)
    {
        $data['user'] = User::where('username', $slug)->first();
        if($data['user']){
            $data['followers'] = Follow::where('following_user_id', $data['user']->id)->get();
            $data['following'] = Follow::where('user_id', $data['user']->id)->get();
            $data['photos'] = Photo::where('user_id', $data['user']->id)->get();
            $data['honors'] = Entry::where('user_id', $data['user']->id)->where('rank', '<>', NULL)->get();
            return view('frontend.profile.index', $data);
        }
        return view('errors.404', $data);
    }

    function getCollections($slug)
    {
        $data['user'] = User::where('username', $slug)->first();
        if($data['user']){
            $data['user'] = User::where('username', $slug)->first();
            $data['followers'] = Follow::where('following_user_id', $data['user']->id)->get();
            $data['following'] = Follow::where('user_id', $data['user']->id)->get();
            $data['collection'] = Collection::where('user_id', $data['user']->id)->get();
            $data['honors'] = Entry::where('user_id', $data['user']->id)->where('rank', '<>', NULL)->get();
            return view('frontend.profile.collections', $data);
        }
        return view('errors.404', $data);
    }

    function getLoves($slug)
    {
        $data['user'] = User::where('username', $slug)->first();
        if($data['user']){
            $data['user'] = User::where('username', $slug)->first();
            $data['followers'] = Follow::where('following_user_id', $data['user']->id)->get();
            $data['following'] = Follow::where('user_id', $data['user']->id)->get();
            $data['photos'] = Photo::where('user_id', $data['user']->id)->get();
            $data['loves'] = Love::where('user_id', $data['user']->id)->get();
            $data['honors'] = Entry::where('user_id', $data['user']->id)->where('rank', '<>', NULL)->get();
            return view('frontend.profile.loves', $data);
        }
        return view('errors.404', $data);
    }

    function getHonors($slug)
    {
        $data['user'] = User::where('username', $slug)->first();
        if($data['user']){
            $data['user'] = User::where('username', $slug)->first();
            $data['followers'] = Follow::where('following_user_id', $data['user']->id)->get();
            $data['following'] = Follow::where('user_id', $data['user']->id)->get();
            $data['photos'] = Photo::where('user_id', $data['user']->id)->get();
            $data['loves'] = Love::where('user_id', $data['user']->id)->get();
            $data['honors'] = Entry::where('user_id', $data['user']->id)->where('rank', '<>', NULL)->get();
            $data['achievements'] = Achievement::find(1);
            return view('frontend.profile.honors', $data);
        }
        return view('errors.404', $data);
    }

    function getPhotos($slug)
    {
        $data['user'] = User::where('username', $slug)->first();
        $data['photos'] = Photo::where('user_id', $data['user']->id)->get();
        $html = view('frontend.profile.appends.photos', $data)->render();
        return response()->json(["result" => "success", "html" => $html]);
    }

    function getLovesData($slug)
    {
        $data['user'] = User::where('username', $slug)->first();
        $data['loves'] = Love::where('user_id', $data['user']->id)->get();
        $html = view('frontend.profile.appends.loves', $data)->render();
        return response()->json(["result" => "success", "html" => $html]);
    }

    function getFollowFromProfile(Request $request)
    {
        $user = User::find(Crypt::decrypt($request->id));
        if(count($user)){
            $exists = Follow::where('user_id', Auth::user()->id)->where('following_user_id', $user->id)->count();
            if(!$exists){
                $follow = Follow::addData($request, $user->id);
                $data['user'] = User::find($follow->following_user_id);
                $check = Notification::where('from_user_id', Auth::user()->id)->where('to_user_id', $user->id)->where('type', 'follow')->first();
                if(!$check){
                    Notification::notifyFollow($follow->user_id, $follow->following_user_id);
                }
                $html = view('frontend.profile.appends.unfollow-profile-button', $data)->render();
                $to = User::find($follow->following_user_id);
                if($user->follow_notification == 1){
                    $user = User::find(Auth::user()->id);
                    $configuration = Configuration::find(1);
                    // Send password reset link.
                    Mail::send('emails.follow', array('to' => $to, 'user' => $user, 'configuration' => $configuration),
                        function($message) use ($to, $configuration){
                        $message->to($to->email)->subject('You have a new follower!');
                        $message->from($configuration->email, $configuration->name);
                    });
                }
                return response()->json(["result" => "success", "html" => $html]);
            }
        }return response()->json(["result" => 'failed']);
    }

    function getUnfollowFromProfile(Request $request)
    {
        $user = User::find(Crypt::decrypt($request->id));
        if(count($user)){
            $exists = Follow::where('user_id', Auth::user()->id)->where('following_user_id', $user->id)->count();
            if($exists){
                $follow = Follow::removeData($request, $user->id);
                $data['user'] = User::find($follow);
                $html = view('frontend.profile.appends.follow-profile-button', $data)->render();
                return response()->json(["result" => "success", "html" => $html]);
            }
        }return response()->json(["result" => 'failed']);
    }

    function getFollowFromPhoto(Request $request)
    {
        $user = User::find(Crypt::decrypt($request->id));
        if(count($user)){
            $exists = Follow::where('user_id', Auth::user()->id)->where('following_user_id', $user->id)->count();
            if(!$exists){
                $follow = Follow::addData($request, $user->id);
                $check = Notification::where('from_user_id', Auth::user()->id)->where('to_user_id', $user->id)->where('type', 'follow')->first();
                if(!$check){
                    Notification::notifyFollow($follow->user_id, $follow->following_user_id);
                }
                $data['user'] = User::find($follow->following_user_id);
                $html = view('frontend.profile.appends.unfollow-button', $data)->render();
                $to = User::find($follow->following_user_id);
                if($user->follow_notification == 1){
                    $user = User::find(Auth::user()->id);
                    $configuration = Configuration::find(1);
                    // Send password reset link.
                    Mail::send('emails.follow', array('to' => $to, 'user' => $user, 'configuration' => $configuration),
                        function($message) use ($to, $configuration){
                        $message->to($to->email)->subject('You have a new follower!');
                        $message->from($configuration->email, $configuration->name);
                    });
                }
                return response()->json(["result" => "success", "html" => $html]);
            }
        }return response()->json(["result" => 'failed']);
    }

    function getUnfollowFromPhoto(Request $request)
    {
        $user = User::find(Crypt::decrypt($request->id));
        if(count($user)){
            $exists = Follow::where('user_id', Auth::user()->id)->where('following_user_id', $user->id)->count();
            if($exists){
                $follow = Follow::removeData($request, $user->id);
                $data['user'] = User::find($follow);
                $html = view('frontend.profile.appends.follow-button', $data)->render();
                return response()->json(["result" => "success", "html" => $html]);
            }
        }return response()->json(["result" => 'failed']);
    }

    function getFollowFromProfilePopup(Request $request)
    {
        $user = User::find(Crypt::decrypt($request->id));
        if(count($user)){
            $check = Follow::where('user_id', Auth::user()->id)->where('following_user_id', $user->id)->count();
            if($check == 0){
                $follow = Follow::addData($request, $user->id);
                $data['value'] = $follow;
                $check = Notification::where('from_user_id', Auth::user()->id)->where('to_user_id', $user->id)->where('type', 'follow')->first();
                if(!$check){
                    Notification::notifyFollow($follow->user_id, $follow->following_user_id);
                }
                $data['user'] = User::find($follow->following_user_id);
                $html = view('frontend.profile.appends.unfollow-button-v2', $data)->render();
                $to = User::find($follow->following_user_id);
                if($user->follow_notification == 1){
                    $user = User::find(Auth::user()->id);
                    $configuration = Configuration::find(1);
                    // Send password reset link.
                    Mail::send('emails.follow', array('to' => $to, 'user' => $user, 'configuration' => $configuration),
                        function($message) use ($to, $configuration){
                        $message->to($to->email)->subject('You have a new follower!');
                        $message->from($configuration->email, $configuration->name);
                    });
                }
                return response()->json(["result" => "success", "html" => $html]);
            }return response()->json(["result" => 'existing']);
        }return response()->json(["result" => 'failed']);
    }

    function getUnfollowFromProfilePopup(Request $request)
    {
        $user = User::find(Crypt::decrypt($request->id));
        if(count($user)){
            $check = Follow::where('user_id', Auth::user()->id)->where('following_user_id', $user->id)->count();
            if($check != 0){
                $follow = Follow::removeData($request, $user->id);
                $data['value'] = $follow;
                $data['user'] = User::find($follow);
                $html = view('frontend.profile.appends.follow-button-v2', $data)->render();
                return response()->json(["result" => "success", "html" => $html]);
            }return response()->json(["result" => 'existing']);
        }return response()->json(["result" => 'failed']);
    }

}