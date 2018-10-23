<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Crypt;
use Tmdb\Laravel\Facades\Tmdb;
use App\Models\DefaultSetting;
use Tmdb\Helper\ImageHelper;
use App\Models\MovieTMDB;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\SearchRepository;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieTrailerController extends Controller
{
    private $movies, $helper, $search;

    function __construct(MovieRepository $movies, ImageHelper $helper, SearchRepository $search)
    {
        $this->movies = $movies;
        $this->helper = $helper;
        $this->search = $search;
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }

    function getIndex(Request $request)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Edit';
        if($request->keywords != null){
            $data['search'] = $this->search->searchMovie($request->keywords, new MovieSearchQuery, array('page' => $request['page']));
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            if($data['search']->getTotalResults() >= 501){$total = 10000;}else{$total = $data['search']->getTotalResults();}
            $data['search'] = new LengthAwarePaginator($data['search'], $total, $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['keywords'] = $request->keywords;
        }else{
            $data['search'] = $this->movies->getPopular(array('page' => $request['page']));
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            if($data['search']->getTotalResults() >= 501){$total = 10000;}else{$total = $data['search']->getTotalResults();}
            $data['search'] = new LengthAwarePaginator($data['search'], $total, $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
        }
        $data['avatar'] = DefaultSetting::find(1);
        return view('backend.movie-trailer.index', $data);
    }

    function getEdit($id)
    {
        $data['segment'] = $this->segment;
        $data['movie'] = $this->movies->load(Crypt::decrypt($id));
        $data['movie_tmdb'] = MovieTMDB::find(Crypt::decrypt($id));
        $data['trailer'] = null;
        if($data['movie_tmdb'] == null){
            $data['movie_tmdb']['id'] = Crypt::decrypt($id);
            $data['movie_tmdb']['trailer'] = null;
            $data['movie_tmdb']['video_host'] = 0;
        }
        foreach ($data['movie']->getVideos() as $key => $value) {
            if($value->getType() == 'Trailer'){
                $data['trailer'] = $value->getKey();
                break;
            }
        }
        if($data['trailer'] == null){
            foreach ($data['movie']->getVideos() as $key => $value) {
                if($value->getType() == 'Teaser'){
                    $data['trailer'] = $value->getKey();
                    break;
                }
            }
        }
        return view('backend.movie-trailer.edit', $data);
    }

    function postEdit(Request $request)
    {
        if($request->id){
            if($request->video_host == 0){
                $link = explode('v=', $request->video_link);
                $link = array_pop($link);
                $check = $this->getFile('https://www.googleapis.com/youtube/v3/videos?part=status&id='.$link.'&key=AIzaSyA6JNEj8nz4tP_eayr3rJ92iNPT0wDoCjE');
                if($check['items']){
                    $request->video_link = $link;
                    MovieTMDB::addTrailer($request);
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
                    MovieTMDB::addTrailer($request);
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
