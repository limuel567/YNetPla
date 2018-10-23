<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Helper;

use Carbon\Carbon;
use Session;
use Redirect;
use Mail;
use Hash;
use File;
use Crypt;
use DB;

class MovieTMDB extends Model{

    protected $table = 'tmdb';

    public static function addTrailer($request){
        $data = self::find(Crypt::decrypt($request->id));
        if($data){
            $data->trailer = $request->video_link;
            $data->video_host = $request->video_host;
            $data->save();    
        }else{
            $data = new self;
            $data->id = Crypt::decrypt($request->id);
            $data->trailer = $request->video_link;
            $data->video_host = $request->video_host;
            $data->save();
        }
        
    }
}