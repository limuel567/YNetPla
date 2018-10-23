<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Helper;
use App\Models\Notification;
use App\Models\Love;
use App\Models\Entry;
use App\Models\Configuration;
use App\User;
use Filestack\FilestackClient;
use Filestack\Filelink;

use Crypt, Auth, View, Mail;

class PhotosController extends Controller {
   
    function getIndex($slug)
    {
        // $data = Comment::find(20);
        // $array = [];
        // $new = [];
        // preg_match_all("/(@\w+)/", $data->content, $matches);
        // foreach ($matches[0] as $username){
        //     $array = $username . ' ';
        // }
        // foreach ($array as $value) {
        //     $check = User::where('username', $value)->first();
        //     if($check){
        //         $new = 
        //     }
        // }
        // $new = preg_replace('/@(\w+)/', '<a href="http://zuslo.com/$1/photos">@$1</a>', $data->content);
        // return $array;
        $data['photo'] = Photo::where('filename', $slug)->first();
        if($data['photo']){
            $comments = Comment::where('photo_id', $data['photo']->id)->oldest();
            $data['comments'] = $comments->take(10)->get();
            $data['total_comments'] = $comments->count();
            $data['user'] = User::find($data['photo']->user_id);
            $data['loves'] = Love::where('photo_id', $data['photo']->id)->get();
            return view('frontend.photos.view', $data);
        }return view('errors.404', $data);
    }

    function postComment(Request $request)
    {
        $photo = Photo::find(Crypt::decrypt($request->id));
        if(count($photo)){
            $data['comment'] = Comment::addData($request, $photo->id);
            $data['user'] = User::find($data['comment']->user_id);
            if(Auth::user()->id != $photo->user_id){
                Notification::notifyComment($photo->id, $data['comment']->user_id, $photo->user_id); // (photo_id, from_user_id, to_user_id)
                $to = User::find($photo->user_id);
                if($to->love_notification == 1){
                    $user = User::find(Auth::user()->id);
                    $configuration = Configuration::find(1);
                    // Send password reset link.
                    Mail::send('emails.comment', array('photo' => $photo, 'to' => $to, 'user' => $user, 'configuration' => $configuration),
                        function($message) use ($to, $configuration){
                        $message->to($to->email)->subject('Someone commented on your photo');
                        $message->from($configuration->email, $configuration->name);
                    });
                }
            }
            $html = View::make('frontend.photos.appends.comment', $data)->render();
            return response()->json(["result"  => 'success', "html" => $html]);
        }return response()->json(["result" => 'invalid']);
    }

    function getComments(Request $request)
    {
        $photo = Photo::find(Crypt::decrypt($request->id));
        if(count($photo)){
            $data['comments'] = Comment::where('photo_id', $photo->id)->oldest()->get();
            $html = View::make('frontend.photos.appends.comments', $data)->render();
            return response()->json(["result"  => 'success', "html" => $html]);
        }return response()->json(["result" => 'invalid']);
    }

    function getDeleteComment(Request $request)
    {
        $cid = Crypt::decrypt($request->id);
        $comment = Comment::find($cid);
        if($comment){
            $comment->delete();
            return response()->json(["result" => 'success', 'cid' => $cid]);
        }return response()->json(["result" => 'failed']);
    }

    function getLovePhoto(Request $request)
    {
        $photo = Photo::find(Crypt::decrypt($request->id));
        if(count($photo)){
            $loves = Love::where('photo_id', $photo->id)->where('user_id', Auth::user()->id)->count();
            if(!$loves){
                Love::lovePhoto($photo->id, Auth::user()->id);
                if(Auth::user()->id != $photo->user_id){
                    Notification::notifyLove($photo->id, Auth::user()->id, $photo->user_id); // (photo_id, from_user_id, to_user_id)
                    $to = User::find($photo->user_id);
                    if($to->love_notification == 1){
                        $user = User::find(Auth::user()->id);
                        $configuration = Configuration::find(1);
                        // Send password reset link.
                        Mail::send('emails.love', array('photo' => $photo, 'to' => $to, 'user' => $user, 'configuration' => $configuration),
                            function($message) use ($to, $configuration){
                            $message->to($to->email)->subject('Someone loved your photo');
                            $message->from($configuration->email, $configuration->name);
                        });
                    }
                }
                $data['photo'] = $photo;
                $data['loves'] = Love::where('photo_id', $photo->id)->count();
                $data['loves_data'] = Love::where('photo_id', $photo->id)->get();
                $html = View::make('frontend.photos.appends.unlove', $data)->render();
                $loves = View::make('frontend.photos.appends.loves-modal', $data)->render();
                return response()->json(["result"  => 'success', "html" => $html, 'loves' => $loves]);
            }
        }return response()->json(["result" => 'invalid']);
    }

    function getUnlovePhoto(Request $request)
    {
        $photo = Photo::find(Crypt::decrypt($request->id));
        if(count($photo)){
            $loves = Love::where('photo_id', $photo->id)->where('user_id', Auth::user()->id)->count();
            if($loves){
                Love::unlovePhoto($photo->id, Auth::user()->id);
                $data['photo'] = $photo;
                $data['loves'] = Love::where('photo_id', $photo->id)->count();
                $data['loves_data'] = Love::where('photo_id', $photo->id)->get();
                $html = View::make('frontend.photos.appends.love', $data)->render();
                $loves = View::make('frontend.photos.appends.loves-modal', $data)->render();
                return response()->json(["result"  => 'success', "html" => $html, 'loves' => $loves]);
            }
        }return response()->json(["result" => 'invalid']);
    }

    function getUploadPhoto(Request $request)
    {
        // declare unique id
        foreach($request->response['filesUploaded'] as $key => $value){
            $settings = Configuration::find(1);
            \Cloudinary::config(array( 
                "cloud_name" => unserialize($settings->cloudinary_api)['cloud_name'], 
                "api_key" => unserialize($settings->cloudinary_api)['api_key'], 
                "api_secret" => unserialize($settings->cloudinary_api)['api_secret'] 
            ));
            $uid = Helper::generateUUID();
            // upload photo to cloudinary
            $standard = \Cloudinary\Uploader::upload($value['url'], array("public_id" => 'private_images/t_standard_fit/'.$uid));
            $thumb = \Cloudinary\Uploader::upload($value['url'], array("public_id" => 'private_images/t_thumb_fit/'.$uid, "width" => 0.5, "height" => 0.5, "crop"=>"fit"));
            $low = \Cloudinary\Uploader::upload($value['url'], array("public_id" => 'private_images/t_low_fit/'.$uid, "width" => 0.2, "height" => 0.2, "crop"=>"fit"));
            // add to database
            $photo = new Photo;
            $photo->user_id = Auth::user()->id;
            $photo->uid = $uid;
            $photo->filename = $request->caption != null ? Helper::seoUrl($request->caption) : $uid;
            $photo->height = $standard['height'];
            $photo->width = $standard['width'];
            $photo->size = $standard['bytes'];
            $photo->low_url = $low['url'];
            $photo->standard_url = $standard['url'];
            $photo->thumb_url = $thumb['url'];
            $photo->save();
        }

        $data['photos'] = Photo::where('user_id', Auth::user()->id)->get();
        $html = View::make('frontend.profile.appends.photo', $data)->render();
        $url = URL(Auth::user()->username.'/photos');
        
        return response()->json(["result" => 'success', 'html' => $html, 'url' => $url]);
    }
    
    function getDeletePhoto(Request $request)
    {
        $photo = Photo::find(Crypt::decrypt($request->id));
        $loves = Love::where('photo_id', $photo->id)->get();
        $comments = Comment::where('photo_id', $photo->id)->get();
        if($photo){
            $photo->delete();
        }
        if(count($loves)){
            $loves->delete();
        }
        if(count($comments)){
            $comments->delete();
        }
        $url = URL(Auth::user()->username.'/photos');
        return response()->json(["result" => 'success', 'url' => $url]);
    }
    
    function getEditPhoto(Request $request, $id)
    {
        $photo = Photo::find(Crypt::decrypt($id));
        if($photo){
            $result = Photo::updatePhoto($request, $photo->id);
            $data['photo'] = $result;
            $html = View::make('frontend.photos.appends.photo-details', $data)->render();
            return response()->json(["result" => 'success', 'html' => $html]);
        }else{
            return response()->json(["result" => 'invalid']);
        }
    }

    function getUploadAvatar(Request $request)
    {
        $settings = Configuration::find(1);
        \Cloudinary::config(array( 
            "cloud_name" => unserialize($settings->cloudinary_api)['cloud_name'], 
            "api_key" => unserialize($settings->cloudinary_api)['api_key'], 
            "api_secret" => unserialize($settings->cloudinary_api)['api_secret'] 
        ));
        // declare unique id
        $uid = Helper::generateUUID();
        // upload photo to cloudinary
        $result = \Cloudinary\Uploader::upload($request->response['filesUploaded'][0]['url'], array("public_id" => 'avatars/'.$uid));
        // add to database
        $user = User::find(Auth::user()->id);
        $user->profile_photo = $result['url'];
        $user->save();

        $data['user'] = $user;
        $html = View::make('frontend.settings.appends.avatar-cover', $data)->render();
        $src = $result['url'];
        return response()->json(["result" => 'success', 'html' => $html, 'src' => $src]);
    }

    function getUploadCover(Request $request)
    {
        $settings = Configuration::find(1);
        \Cloudinary::config(array( 
            "cloud_name" => unserialize($settings->cloudinary_api['cloud_name']), 
            "api_key" => unserialize($settings->cloudinary_api['api_key']), 
            "api_secret" => unserialize($settings->cloudinary_api['api_secret']) 
        ));
        // declare unique id
        $uid = Helper::generateUUID();
        // upload photo to cloudinary
        $result = \Cloudinary\Uploader::upload($request->response['filesUploaded'][0]['url'], array("public_id" => 'covers/'.$uid));
        // add to database
        $user = User::find(Auth::user()->id);
        $user->cover_photo = $result['url'];
        $user->save();

        $data['user'] = $user;
        $html = View::make('frontend.settings.appends.avatar-cover', $data)->render();
        return response()->json(["result" => 'success', 'html' => $html]);
    }

    function getUploadPhotoEntry(Request $request, $id)
    {
        $challenge = Challenge::find(Crypt::decrypt($id));
        $settings = Configuration::find(1);
        \Cloudinary::config(array( 
            "cloud_name" => unserialize($settings->cloudinary_api)['cloud_name'], 
            "api_key" => unserialize($settings->cloudinary_api)['api_key'], 
            "api_secret" => unserialize($settings->cloudinary_api)['api_secret'] 
        ));

        if($challenge->status == 0){
            $exist = Entry::where('challenge_id', $challenge->id)->where('user_id', Auth::user()->id)->first();
            if(!$exist){
                // declare unique id
                $uid = Helper::generateUUID();
                // upload photo to cloudinary
                $standard = \Cloudinary\Uploader::upload($request->response['filesUploaded'][0]['url'], array("public_id" => 'private_images/t_standard_fit/'.$uid));
                $thumb = \Cloudinary\Uploader::upload($request->response['filesUploaded'][0]['url'], array("public_id" => 'private_images/t_thumb_fit/'.$uid, "width" => 0.5, "height" => 0.5, "crop"=>"fit"));
                $low = \Cloudinary\Uploader::upload($request->response['filesUploaded'][0]['url'], array("public_id" => 'private_images/t_low_fit/'.$uid, "width" => 0.2, "height" => 0.2, "crop"=>"fit"));
                // add to database
                $photo = new Photo;
                $photo->user_id = Auth::user()->id;
                $photo->uid = $uid;
                $photo->filename = $uid;
                $photo->height = $standard['height'];
                $photo->width = $standard['width'];
                $photo->size = $standard['bytes'];
                $photo->low_url = $low['url'];
                $photo->standard_url = $standard['url'];
                $photo->thumb_url = $thumb['url'];
                $photo->save();

                $entry = Challenge::enterChallenge($challenge->id, $photo->id);
                $url = URL('challenges/'.$entry->slug);
                return response()->json(["result" => 'success', 'url' => $url]);
            }
        }return response()->json(["result" => 'invalid']);
    }

}