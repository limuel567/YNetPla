<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SeasonPremieres;
use App\Models\Validators;
use App\Models\DefaultSetting;
use App\Models\TvMaze;
use Carbon\Carbon;
use Crypt, Session;
use Tmdb\Laravel\Facades\Tmdb;
use Illuminate\Pagination\LengthAwarePaginator;
use JPinkney\TVMaze\Client;

class SeasonPremiereController extends Controller {
   
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
        $data['season_premieres'] = SeasonPremieres::get();
        return view('backend.season-premieres.index', $data);
    }

    function getEdit(Request $request)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Edit';
        if($request->keywords != null){
            $data['search'] = new Collection(SeasonPremieres::where('name', 'like', '%' . $request->keywords . '%')->limit(800)->get());
            $data['keywords'] = $request->keywords;
        }else{
            $data['search'] = new Collection(SeasonPremieres::limit(800)->get());
        }
        $data['entries_count'] = count($data['search']);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentPageSearchResults = $data['search']->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data['search'] = new LengthAwarePaginator($currentPageSearchResults, count($data['search']), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
        $data['avatar'] = DefaultSetting::find(1);
        return view('backend.season-premieres.create', $data);
    }

    function postCreate(Request $request)
    {
        $id = Crypt::decrypt($request->selected);
        if($request->status == 'save'){
            $shows = $this->getFile('https://api.tvmaze.com/shows/'.$id.'?embed=episodes');
            krsort($shows['_embedded']['episodes']);
            foreach ($shows['_embedded']['episodes'] as $key => $value) {
                if($value['number'] == 1){
                    if($value['airdate'].' '.$value['airtime'] >= date('Y-m-d H:i')){
                        $date = $value;
                        break;  
                    }else {
                        $date = $value;
                        break;    
                    }
                }
            }
            if($date['airdate'].' '.$date['airtime'] <= date('Y-m-d H:i') || $date['number'] != 1){
                return response()->json(["result" => "alreadyPremiere"]);
            }else{
                $shows = $this->getFile('https://api.tvmaze.com/shows/'.$id.'?embed=nextepisode');
                $request->name = $shows['name'];
                $request->encoded_json = json_encode($shows);
                $request->premiere_date = $date['airdate'].' '.$date['airtime'];
                SeasonPremieres::createSeasonPremieres($request);
                return response()->json(["result" => "success"]);
            }
        }else{
            SeasonPremieres::deleteSeasonPremieres($request, $id);
            return response()->json(["result" => "success"]);    
        }
    }

    function getCreate(Request $request)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Add';
        if($request->keywords != null){
            $data['search'] = new Collection(TvMaze::where('name', 'like', '%' . $request->keywords . '%')->limit(800)->get());
            $data['keywords'] = $request->keywords;
        }else{
            $data['search'] = new Collection(TvMaze::orderBy('weight', 'desc')->limit(800)->get());
        }
        $data['entries_count'] = count($data['search']);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentPageSearchResults = $data['search']->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data['search'] = new LengthAwarePaginator($currentPageSearchResults, count($data['search']), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
        $data['avatar'] = DefaultSetting::find(1);
        return view('backend.season-premieres.create', $data);
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
}