<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Subscription;
use App\Models\Article;
use App\Models\Validators;
use App\Models\Helper;
use App\Models\Configuration;
use App\Models\DefaultSetting;
use App\Models\Notification;
use App\Models\Pages\Pages;
use App\Models\Pages\PageSection;
use App\Models\Pages\PageContent;
use Carbon\Carbon;
use App\User;
use Auth, Crypt, Mail, Session;
use App\Models\Admin;
use App\Models\Schedule;
use App\Models\TvMaze;
use App\Models\SeasonPremieres;
use App\Models\TopPicks;
use App\Models\TopPicksData;
use Tmdb\Laravel\Facades\Tmdb;
use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\GenreRepository;
use Tmdb\Repository\SearchRepository;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Illuminate\Pagination\LengthAwarePaginator;
use JPinkney\TVMaze\Client;

class MainController extends Controller {

    private $movies, $helper, $search, $client, $genre;

    function __construct(GenreRepository $genre, Client $client, MovieRepository $movies, ImageHelper $helper, SearchRepository $search)
    {
        $this->segment = request()->segment(2);
        if($this->segment == null){
            $this->segment = 'no-segment';
        }
        $this->client = $client;
        $this->movies = $movies;
        $this->helper = $helper;
        $this->search = $search;
        $this->genre = $genre;
		// for ($i=0; $i > -1; $i++) { 
		// 	Configuration::updateTVmaze($i);
        // }
        #SAVING TODAY'S SCHEDULE#
        $check_schedule = Schedule::find(1);
        $array_tv = [];
        $time['20'] = [];
        $time['21'] = [];
        $time['22'] = [];
        $time['23'] = [];
        $this->config = Configuration::find(1);
        if($check_schedule){
            if($check_schedule->date != date('Y-m-d')){
                $check_updates = $this->getFile('https://api.tvmaze.com/show?page='.$this->config->last_page);
                if(count($check_updates) != $this->config->last_count){
                    Configuration::updateTVmaze($this->config->last_page);
                }else{
                    $check_update_page = $this->getFile('https://api.tvmaze.com/show?page='.($this->config->last_page+1));
                    if($check_update_page){
                        TvMaze::attempt($this->config->last_page+1);    
                        Configuration::updatePageAndCount($this->config->last_page+1, count($check_update_page));
                    }
                }

                $schedule = $this->client->TVMaze->getSchedule('us',date('Y-m-d'));
                foreach ($schedule as $key => $value) {
                    if(date('Y-m-d H:i A', strtotime(date('Y-m-d').' 08:00 PM')) <= date('Y-m-d H:i A', strtotime($value->airdate.' '.$value->airtime)) && $value->show['weight'] > 90){
                        if(count($array_tv) != 4){
                            $array_tv[] = $value;
                        }
                        if($value->airtime >= date('H:i', strtotime('08:00 PM')) && $value->airtime < date('H:i', strtotime('09:00 PM'))){
                            $time['20'][] = $value;
                        }
                        if($value->airtime >= date('H:i', strtotime('09:00 PM')) && $value->airtime < date('H:i', strtotime('10:00 PM'))){
                            $time['21'][] = $value;
                        }
                        if($value->airtime >= date('H:i', strtotime('10:00 PM')) && $value->airtime < date('H:i', strtotime('11:00 PM'))){
                            $time['22'][] = $value;
                        }
                        if($value->airtime >= date('H:i', strtotime('11:00 PM'))){
                            $time['23'][] = $value;
                        }
                    }
                }
                Schedule::updateSchedule($time, $array_tv, date('Y-m-d'));
            }else{
                $this->season_premieres = SeasonPremieres::orderBy('premiere_date')->get();
                foreach ($this->season_premieres as $key => $value) {
                    if ($value['premiere_date'] <= date('Y-m-d H:i:s')) {
                        $this->delete = SeasonPremieres::find($value['id']);
                        $this->delete->delete();
                    } else {
                        break;
                    }
                }
                if(date('Y-m-d', strtotime($this->config->last_updated_date.'+7 days')) < date('Y-m-d')){
                    if($this->config->last_updated_page >= $this->config->last_page){
                        $this->config->last_updated_page = 0;   
                        $this->config->last_updated_date = date('Y-m-d');
                        $this->config->save(); 
                    }else{
                        $updateTVMaze = Configuration::updateTVmazeShow($this->config->last_updated_page);
                        $this->config->last_updated_page = $updateTVMaze + 1;
                        $this->config->save();
                    }
                }
            }
        }else{
            $schedule = $this->client->TVMaze->getSchedule('us',date('Y-m-d'));
            foreach ($schedule as $key => $value) {
                if(date('Y-m-d H:i A', strtotime(date('Y-m-d').' 08:00 PM')) <= date('Y-m-d H:i A', strtotime($value->airdate.' '.$value->airtime)) && $value->show['weight'] > 90){
                    if(count($array_tv) != 4){
                        $array_tv[] = $value;
                    }
                    if($value->airtime >= date('H:i', strtotime('08:00 PM')) && $value->airtime < date('H:i', strtotime('09:00 PM'))){
                        $time['20'][] = $value;
                    }
                    if($value->airtime >= date('H:i', strtotime('09:00 PM')) && $value->airtime < date('H:i', strtotime('10:00 PM'))){
                        $time['21'][] = $value;
                    }
                    if($value->airtime >= date('H:i', strtotime('10:00 PM')) && $value->airtime < date('H:i', strtotime('11:00 PM'))){
                        $time['22'][] = $value;
                    }
                    if($value->airtime >= date('H:i', strtotime('11:00 PM'))){
                        $time['23'][] = $value;
                    }
                }
            }
            Schedule::createSchedule($time, $array_tv, date('Y-m-d'));    
        }
        #END OF SAVING TODAY'S SCHEDULE#
        parent::__construct();
    }

    protected $fillable = [
        'username','full_name','bio','email','password',
    ];

    protected $hidden = [
        'password','crypted_password','remember_token',
    ];
    
    function getIndex()
    {
        $data['segment'] = $this->segment;
        // $test_data_shows = TvMaze::orderBy('weight', 'desc')->first();
        // $test_data_episodes = $this->getFile('https://api.tvmaze.com/show/'.$test_data_shows['id'].'/episodes');
        // dd($test_data_episodes);
        // for ($i=134; $i > -1; $i++) { 
        //     TvMaze::updateStatus($i);
        // }
        // $arrow = $this->client->TVMaze->search('better call saul');
        // dd($arrow);
        if(Admin::check()){
            
            $popular = $this->movies->getPopular(array('region' => 'us'));
            $data['movie'] = $popular;
            $data['books'] = $book_results = $this->getFile('https://api.nytimes.com/svc/books/v3/lists/overview.json?api-key=6583adcca8114243ac4e05f18a06a66e');
            $data['articles'] = Article::orderBy('updated_at','desc')->limit(4)->get();
            $data['stored_shows'] = TvMaze::where('weight', '>=', 98)->where('weight', '<=', 100)->inRandomOrder()->limit(4)->get();
            $data['subscription'] = Subscription::get();
            $data['page_content'] = PageContent::getData('none',1);
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            return view('frontend.index', $data);
        }
        return view('backend.login', $data);
    }
    
    function getComingSoonMovies(Request $request)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            if($request['page'] == null){$request['page'] = 1;}
            if($request->keywords != null){
                $popular = $this->search->searchMovie($request->keywords, new MovieSearchQuery, array('page' => $request['page']));
                $data['keywords'] = $request->keywords;
            }else{
                $popular = $this->movies->getUpcoming(array('page' => $request['page'], 'region' => 'us'));
                $data['keywords'] = '';
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            if($popular->getTotalResults() >= 501){$total = 10000;}else{$total = $popular->getTotalResults();}
            $data['entries'] = new LengthAwarePaginator($popular, $total, $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            return view('frontend.ComingSoon', $data);
        }
        return view('backend.login', $data);
    }

    function getSeasonPremieres(Request $request)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            if($request['page'] == null){$request['page'] = 1;}
			$data['page'] = $request['page'];
            //SEASON PREMIERES
            $array_premieres = SeasonPremieres::get();
            $col = new Collection($array_premieres);
            //END SEASON PREMIERES
            $data['keywords'] = '';
            $data['entries_count'] = count($col);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data['entries'] = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            return view('frontend.ComingSoon', $data);
        }
        return view('backend.login', $data);
    }

    function getPopularMovies(Request $request)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            if($request['page'] == null){$request['page'] = 1;}
			$data['page'] = $request['page'];
            if($request->keywords != null){
                if($request->genre != null && $request->genre != 'All-Genre'){
                    $popular = $this->genre->getMovies($request->genre, array('page' => $request['page'], 'region' => 'us'));
                    $data['genre_name'] = $this->genre->load($request->genre)->getName();
                    $data['genre'] = $request->genre;
                    $data['keywords'] = '';
                }else{
                    $popular = $this->search->searchMovie($request->keywords, new MovieSearchQuery, array('page' => $request['page']));
                    $data['genre'] = 'All-Genre';
                    $data['keywords'] = $request->keywords;
                }
            }else{
                if($request->genre != null && $request->genre != 'All-Genre'){
                    $popular = $this->genre->getMovies($request->genre, array('page' => $request['page'], 'region' => 'us'));
                    $data['genre_name'] = $this->genre->load($request->genre)->getName();
                    $data['genre'] = $request->genre;
                }else{
                    
                    $popular = $this->movies->getPopular(array('page' => $request['page'], 'region' => 'us'));
                    $data['genre'] = 'All-Genre';
                }
                $data['keywords'] = '';
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            if($popular->getTotalResults() >= 501){$total = 10000;}else{$total = $popular->getTotalResults();}
            $data['entries'] = new LengthAwarePaginator($popular, $total, $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            $data['now_playing'] = $this->movies->getNowPlaying(array('region' => 'US'));
            $data['top_picks'] = TopPicks::find(1);
            $data['genres'] = $this->genre->loadMovieCollection();
            $data['selected'] = TopPicksData::where('top_picks_id', 1)->get();
            return view('frontend.MoviesBooks', $data);
        }
        return view('backend.login', $data);
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

    function getPopularTVShow(Request $request)
    {
        $data['segment'] = $this->segment;
        // $sched = $this->getFile('https://api.tvmaze.com/schedule/full');
        // $test_shows = TvMaze::orderBy('weight', 'desc')->limit(800)->get();
        // $array_of_shows = [];
        // foreach($test_shows as $key => $value){
        //     $array_of_shows[] = unserialize($value['serialize']);
        // }
        // dd($sched);
        if(Admin::check()){
            $schedule_data = Schedule::find(1);
            $time = json_decode($schedule_data->data, TRUE);
            $time['schedule'] = json_decode($schedule_data->featured, TRUE);
            $data['time'] = $time;
            //SEASON PREMIERES
            $data['premieres'] = SeasonPremieres::limit(4)->get();
            //END SEASON PREMIERES
            if($request['page'] == null){$request['page'] = 1;}
			$data['page'] = $request['page'];
            if($request->keywords != null){
                if($request->genre != null && $request->genre != 'All-Genre'){
                    $col = new Collection(TvMaze::where(function ($q) use ($request) {
                        $q->where('name', 'sounds like', '%' . $request->keywords . '%');
                        $q->orWhere('name', 'like', '%' . $request->keywords . '%');
                    })->where('genre', 'like', '%' . $request->genre . '%')->orderBy('weight', 'desc')->limit(800)->get());
                }else{
                    $col = new Collection(TvMaze::where(function ($q) use ($request) {
                        $q->where('name', 'sounds like', '%' . $request->keywords . '%');
                        $q->orWhere('name', 'like', '%' . $request->keywords . '%');
                    })->orderBy('weight', 'desc')->limit(800)->get());
                }
                $data['keywords'] = $request->keywords;
                $data['genre'] = $request->genre;
            }else{
                if($request->genre != null){
                    if($request->genre != 'All-Genre'){
                        $col = new Collection(TvMaze::where('genre', 'like', '%' . $request->genre . '%')->orderBy('weight', 'desc')->limit(800)->get());
                    }else{
                        $col = new Collection(TvMaze::orderBy('weight', 'desc')->limit(800)->get());
                    }
                    $data['genre'] = $request->genre;
                }else{
                    $col = new Collection(TvMaze::orderBy('weight', 'desc')->limit(800)->get());
                    $data['genre'] = 'All-Genre';
                }
                $data['keywords'] = '';
            }
            $data['entries_count'] = count($col);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 8;
            $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data['entries'] = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            $data['selected'] = TopPicksData::where('top_picks_id', 2)->get();
            return view('frontend.MoviesBooks', $data);
        }
        return view('backend.login', $data);
    }

    function getInnerMovies($id)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            $data['keywords'] = '';
            $id = Crypt::decrypt($id); 
            // $this->movies->getUpcoming(array('region' => 'US'));
            $data['details'] = $this->movies->load($id);
            $data['array_videos'] = $this->movies->getVideos($id);
            $data['videos'] = null;
            foreach ($data['array_videos'] as $key => $value) {
                if($value->getType() == 'Trailer'){
                    $data['videos'] = $value->getKey();
                    break;
                }
            }
            if($data['videos'] == null){
                foreach ($data['array_videos'] as $key => $value) {
                    if($value->getType() == 'Teaser'){
                        $data['videos'] = $value->getKey();
                        break;
                    }
                }
            }
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            $data['now_playing'] = $this->movies->getNowPlaying(array('region' => 'US'));
            $data['top_picks'] = TopPicks::find(1);
            $data['selected'] = TopPicksData::where('top_picks_id', 1)->get();
            return view('frontend.inner', $data);
        }
        return view('backend.login', $data);
    }
    function getInnerTVShow($id)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            //START OF SCHEDULE
            $schedule_data = Schedule::find(1);
            $time = json_decode($schedule_data->data, TRUE);
            $time['schedule'] = json_decode($schedule_data->featured, TRUE);
            $data['time'] = $time;
            //END OF SCHEDULE
            $data['keywords'] = '';
            $id = Crypt::decrypt($id);
            $data['details'] = $this->client->TVMaze->getDetailsByShowID($id);
            $current_date = date('Y-m-d');
            if($data['details'][3] != null && $data['details'][2] != null){
                krsort($data['details'][3]);
                $data['latest_episode']= end($data['details'][2])->number;
                foreach ($data['details'][3] as $key => $season) {
                    if (($season->premiereDate <= $current_date) && $season->premiereDate != null) {
                        $data['latest_season'] = $season->number;
                        break;
                    }
                }
            }else{
                $data['latest_episode']= 1;
                $data['latest_season'] = 1;
            }
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            $data['top_picks'] = TopPicks::find(2);    
            $data['selected'] = TopPicksData::where('top_picks_id', 2)->get();
            return view('frontend.inner', $data);
        }
        return view('backend.login', $data);
    }

    function getSchedule(Request $request)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1); 
            return view('frontend.schedule', $data);
        }
        return view('backend.login', $data);
    }

    function getArticle(Request $request)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            if($request['page'] == null){$request['page'] = 1;}
			$data['page'] = $request['page'];
            if($request->keywords != null){
                $col = new Collection(Article::where('name', 'like', '%' . $request->keywords . '%')->orderBy('created_at', 'desc')->get());
                $data['keywords'] = $request->keywords;
            }else{
                $col = new Collection(Article::orderBy('created_at', 'desc')->get());
                $data['keywords'] = '';
            }
            $data['entries_count'] = count($col);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data['entries'] = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            return view('frontend.articles', $data);
        }
        return view('backend.login', $data);
    }

    function getArticleInner($id)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            $id = Crypt::decrypt($id); 
            $data['keywords'] = '';
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            $data['articles'] = Article::orderBy('updated_at','desc')->get();
            $data['selected'] = Article::find($id);
            return view('frontend.article-inner', $data);
        }
        return view('backend.login', $data);
    }

    function getPopularBooks()
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            $data['names'] = $this->getFile('https://api.nytimes.com/svc/books/v3/lists/names.json?api-key=6583adcca8114243ac4e05f18a06a66e');
            foreach ($data['names']['results'] as $key => $value) {
                if($value['updated'] == 'WEEKLY'){
                    $data['name_lists']['weekly'][] = ['list_name_encoded' => $value['list_name_encoded'], 'display_name' => $value['display_name']];
                }else{
                    $data['name_lists']['monthly'][] = ['list_name_encoded' => $value['list_name_encoded'], 'display_name' => $value['display_name']];
                }
            }
            $data['books'] = $this->getFile('https://api.nytimes.com/svc/books/v3/lists.json?api-key=6583adcca8114243ac4e05f18a06a66e&list='.$data['name_lists']['weekly'][0]['list_name_encoded']);
            dd($data['books']);
            foreach ($data['books']['results'] as $key => $value) {
                if(count($value['isbns']) != 0){
                    $data['books_data'][] = $this->getFile('https://www.googleapis.com/books/v1/volumes?q=isbn:'.$value['isbns'][0]['isbn10']);
                }
            }
            dd($data['books_data']);
            // $data['books'] = $this->getFile('https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json?api-key=6583adcca8114243ac4e05f18a06a66e');
            // foreach ($data['books']['results'] as $key => $value) {
            //     if(count($value['isbns']) != 0){
            //         $data['books_data'][] = $this->getFile('https://www.googleapis.com/books/v1/volumes?q=isbn:'.$value['isbns'][0]['isbn10']);
            //     }
            // }
            // dd($data['books_data']);
            return view('frontend.article-inner', $data);
        }
        return view('backend.login', $data);
    }

    function getBookInner(Request $request)
    {
        $data['segment'] = $this->segment;
        if(Admin::check()){
            if($request['page'] == null){$request['page'] = 1;}
			$data['page'] = $request['page'];
            if($request->keywords != null){
                $col = new Collection(Article::where('name', 'like', '%' . $request->keywords . '%')->orderBy('created_at', 'desc')->get());
                $data['keywords'] = $request->keywords;
            }else{
                $col = new Collection(Article::orderBy('created_at', 'desc')->get());
                $data['keywords'] = '';
            }
            $data['entries_count'] = count($col);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 20;
            $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data['entries'] = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );
            $data['footer'] = PageContent::getData('none',2);
            $data['settings'] = DefaultSetting::find(1);
            return view('frontend.articles', $data);
        }
        return view('backend.login', $data);
    }

    function getApiTesting()
    {
        $api_data = $this->getFile('https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json?api-key=6583adcca8114243ac4e05f18a06a66e');
        dd($api_data);
    }

    function download_page($path){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);          
        curl_close($ch);
        return $retValue;
    }

    function getApiTestingXML()
    {
        $sXML = $this->download_page('https://www.goodreads.com/book/show/50.xml?key=Fgs93Xo55oAAMFOgngpcvA');
        $oXML = new \SimpleXMLElement($sXML);
        dd($oXML);
        foreach($oXML->entry as $oEntry){
            $try[] = $oEntry->title . "\n";
        }
        dd($oXML);
    }

}