<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Comment;
use App\User;

class PhotosController extends Controller {
   
    function getIndex()
    {
        $data['photos'] = Photo::orderBy('created_at', 'desc')->get();
        return view('backend.photos.index', $data);
    }

    function getView($id)
    {
        $data['photo'] = Photo::where('filename', $id)->first();
        if ($data['photo']) {
            $data['comments'] = Comment::where('photo_id', $data['photo']->id)->latest()->get();
            $data['user'] = User::find($data['photo']->user_id);
            return view('backend.photos.view', $data);
        } else {
            return view('errors.404', $data);
        }
        
    }

}