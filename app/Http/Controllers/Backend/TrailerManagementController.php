<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TopPicks;
use App\Models\Validators;
use App\Models\DefaultSetting;
use App\Models\TvMaze;
use Carbon\Carbon;
use Crypt, Session, DataTables;
use Illuminate\Pagination\LengthAwarePaginator;
use JPinkney\TVMaze\Client;

class TrailerManagementController extends Controller {
   
    private $movies, $helper, $search, $client;

    function __construct(Client $client)
    {
        $this->client = $client;
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }
    function getIndex()
    {
        $data['segment'] = $this->segment;
        return view('backend.trailer-management.index', $data);
    }

    function getNullTvSeries()
    {
        $null = TvMaze::select('id', 'name', 'status', 'genre', 'weight', 'updated_at')->where('trailer', null)->orderBy('weight', 'desc');
        return Datatables::of($null)->make(true);
    }

    function getNotNullTvSeries()
    {
        $null = TvMaze::select('id', 'name', 'status', 'genre', 'weight', 'updated_at')->where('trailer', '<>', null)->orderBy('weight', 'desc');
        return Datatables::of($null)->make(true);
    }

    function getEdit(Request $request,$id)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Edit';
        $data['tv_series'] = TvMaze::find($id);
        $data['avatar'] = DefaultSetting::find(1);
        return view('backend.trailer-management.create', $data);
    }

    private function getFile($url)
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

    function postCreate(Request $request)
    {
        if($request->id){
            if($request->video_host == 0){
                $link = explode('v=', $request->video_link);
                $link = array_pop($link);
                $check = $this->getFile('https://www.googleapis.com/youtube/v3/videos?part=status&id='.$link.'&key=AIzaSyA6JNEj8nz4tP_eayr3rJ92iNPT0wDoCjE');
                if($check['items']){
                    $request->video_link = $link;
                    TvMaze::updateTrailer($request);
                    return response()->json(["result" => "success"]);
                }else{
                    if($request->video_link){
                        return response()->json(["result" => "youtube"]);
                    }else{
                        return response()->json(["result" => "failed"]);
                    }
                }
            }else{
                $link = explode('.com/', $request->video_link);
                $link = array_pop($link);
                $check = $this->getFile('https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/'.$link);
                if($check){
                    $request->video_link = $link;
                    TvMaze::updateTrailer($request);
                    return response()->json(["result" => "success"]);
                }else{
                    if($request->video_link){
                        return response()->json(["result" => "vimeo"]);
                    }else{
                        return response()->json(["result" => "failed"]);
                    }
                }
            }
        }else{
            return response()->json(["result" => "failed"]);
        }
    }
}