<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TopPicks;
use App\Models\TopPicksData;
use App\Models\Validators;
use App\Models\DefaultSetting;
use App\Models\TvMaze;
use Carbon\Carbon;
use Crypt, Session;
use Tmdb\Laravel\Facades\Tmdb;
use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\SearchRepository;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Illuminate\Pagination\LengthAwarePaginator;
use JPinkney\TVMaze\Client;

class TopPicksController extends Controller {
   
    private $movies, $helper, $search, $client;

    function __construct(Client $client, MovieRepository $movies, ImageHelper $helper, SearchRepository $search)
    {
        $this->client = $client;
        $this->movies = $movies;
        $this->helper = $helper;
        $this->search = $search;
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
    }
    function getIndex()
    {
        $data['segment'] = $this->segment;
        $data['top_picks'] = TopPicks::get();
        return view('backend.top-picks.index', $data);
    }

    function getEdit(Request $request,$id)
    {
        $data['segment'] = $this->segment;
        $data['label'] = 'Edit';
        $data['top_picks'] = TopPicks::find(Crypt::decrypt($id));
        if($request->keywords != null){
            if($data['top_picks']->name == 'Movie'){
                $data['selected'] = TopPicksData::where('top_picks_id', 1)->get();
                for ($i=count($data['selected']); $i < 4 ; $i++) { 
                    $data['selected'][] = null;
                }
                $data['search'] = $this->search->searchMovie($request->keywords, new MovieSearchQuery, array('page' => $request['page']));
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 20;
                if($data['search']->getTotalResults() >= 501){$total = 10000;}else{$total = $data['search']->getTotalResults();}
                $data['search'] = new LengthAwarePaginator($data['search'], $total, $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            }else{
                $data['selected'] = TopPicksData::where('top_picks_id', 2)->get();
                for ($i=count($data['selected']); $i < 8 ; $i++) { 
                    $data['selected'][] = null;
                }
                $data['search'] = new Collection($this->client->TVMaze->search($request->keywords));
                $data['entries_count'] = count($data['search']);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 20;
                $currentPageSearchResults = $data['search']->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $data['search'] = new LengthAwarePaginator($currentPageSearchResults, count($data['search']), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            }
            $data['keywords'] = $request->keywords;
        }else{
            if($data['top_picks']->name == 'Movie'){
                $data['selected'] = TopPicksData::where('top_picks_id', 1)->get();
                for ($i=count($data['selected']); $i < 4 ; $i++) { 
                    $data['selected'][] = null;
                }
                $data['search'] = $this->movies->getPopular(array('page' => $request['page']));
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 20;
                if($data['search']->getTotalResults() >= 501){$total = 10000;}else{$total = $data['search']->getTotalResults();}
                $data['search'] = new LengthAwarePaginator($data['search'], $total, $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            }else{
                $data['selected'] = TopPicksData::where('top_picks_id', 2)->get();
                for ($i=count($data['selected']); $i < 8 ; $i++) { 
                    $data['selected'][] = null;
                }
                $data['search'] = new Collection(TvMaze::orderBy('weight', 'desc')->limit(800)->get());
                $data['entries_count'] = count($data['search']);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 20;
                $currentPageSearchResults = $data['search']->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $data['search'] = new LengthAwarePaginator($currentPageSearchResults, count($data['search']), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            }
        }
        $data['avatar'] = DefaultSetting::find(1);
        return view('backend.top-picks.create', $data);
    }

    function postCreate(Request $request, $id)
    {
        if($request->id){
            $check = TopPicks::find(Crypt::decrypt($request->id));
            if($check->name == 'TV Show'){
                $exist = TopPicksData::where('top_picks_id', Crypt::decrypt($request->id))->where('tvshow_id', Crypt::decrypt($id))->first();
                if($exist){
                    $exist->delete();
                    return response()->json(["result" => "deleted"]);
                }else{
                    $request->data = $this->client->TVMaze->getShowByShowID(Crypt::decrypt($id));
                    TopPicksData::addData($request);
                    return response()->json(["result" => "success"]);
                }
            }else{
                $exist = TopPicksData::where('top_picks_id', Crypt::decrypt($request->id))->where('movie_id', Crypt::decrypt($id))->first();
                if($exist){
                    $exist->delete();
                    return response()->json(["result" => "deleted"]);
                }else{
                    $request->data = $this->movies->load(Crypt::decrypt($id));
                    TopPicksData::addData($request);
                    return response()->json(["result" => "success"]);
                }
            }
        }else{
            TopPicks::createTopPicks($request, true);
        }
    }
}