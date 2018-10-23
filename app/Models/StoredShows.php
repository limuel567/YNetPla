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

class StoredShows extends Model{

    protected $table = 'sessions';

    public static function attempt(){
        // Get data result
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;
        $shows1 = self::getFile('https://api.tvmaze.com/shows');
        for ($i=1; $i > 4; $i++) { 
            $shows2 = self::getFile('https://api.tvmaze.com/shows?page='.$i);
            if($shows2 == false){
                $i = 0;
            }else{
                $shows1 = array_merge($shows1,$shows2); 
            }
        }
        usort($shows, function($a, $b) {
            if($a['weight']==$b['weight']) return 0;
            return $a['weight'] < $b['weight']?1:-1;
        });
        $col = new Collection($shows);
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $result = new LengthAwarePaginator($currentPageSearchResults, count($shows), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
        // Check if there is a result
        if($result){
            // Check if password matches
            Session::put('stored_shows', $result);
            return true;
        }
        return false;
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