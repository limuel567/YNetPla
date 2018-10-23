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

class TvMaze extends Model{

    protected $table = 'tv_maze';

    public static function attempt($page=0){
        // Get data result
        $shows = self::getFile('https://api.tvmaze.com/show?page='.$page);
        foreach($shows as $key => $show){
            $data = new self;
            $data->id = $show['id'];
			$data->name = $show['name'];
            $data->weight = $show['weight'];
			$data->genre = implode(", ",$show['genres']);
            $data->status = $show['status'];
            $data->serialize = serialize($show);
            $data->save();
        }
    }

    public static function updateStatus($page=0){
        // Get data result
        $shows = self::getFile('https://api.tvmaze.com/show?page='.$page);
        foreach($shows as $key => $show){
            $data = self::find($show['id']);
            $data->status = $show['status'];
            $data->save();
        }
    }

    public static function updateTrailer($request){
        // Get data result
        $data = self::find(Crypt::decrypt($request->id));
        $data->trailer = $request->video_link;
        $data->video_host = $request->video_host;
        $data->save();
    }

    private static function getFile($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($result, TRUE);
		if (is_array($response) && count($response) > 0 && (!isset($response['status']) || $response['status'] != '404')) {
			return $response;
		}
		
		return false;
    }

    public static function check(){
        // Check if session is true
        return (Session::get('stored_shows')) ? true : false;
    }

    public static function forgetSession(){
        // Destroy session
        Session::forget('stored_shows');
        return Redirect::to('/admin/login');
    }
}