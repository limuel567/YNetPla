@extends('frontend.layout')
@section('title','YNetPla')
@section('content')
<div class="row" style="margin:unset;">
    <?php $count = 0; $displayeditem = []; $cnt = 0;?>
    <div class="container-fluid latest-banner" style="background-image: url('frontend/img/latest-banner.png');">
        <h2>{{Request::segment(1)=='popular-movies' ? 'Now Playing Movies' : 'Popular Shows Airing Tonight'}}</h2>
    </div>
    <div id="content-inner" {{Request::segment(1)=='popular-movies' ? '' : 'class=col-md-12'}} {{Request::segment(1)=='popular-movies' ? '' : 'style=padding:unset;'}}>
        <div class="container-fluid search-latest-section" style="background-image: url('{!!'frontend/img/top-book-section.png'!!}');">
            <div class="row top-holder">
                <a href="popular-movies"><button>MOVIES</button></a>
                <a href="popular-tv-series"><button>TV SERIES</button></a>
                @if (Request::segment(1) == 'popular-tv-series')
                <a id="toggle-sidebar" style="position:absolute;right:0;"><button style="width: 170px;">VIEW SCHEDULES</button></a>
                @else
                <a class="coming-soon-movies" href="coming-soon-movies" style="position:absolute;right:0;"><button style="width: 170px;">COMING SOON MOVIES</button></a>
                @endif
                <form action="{{URL(Request::segment(1))}}" class="form">
                    <input name="keywords" type="text" value="{!! $keywords != '' ? $keywords : '' !!}" placeholder="Search {!! Request::segment(1) == 'popular-movies' ? 'Movies' : 'TV Series' !!}">
                    <button><i class="fa fa-search"></i></button>
                    <div class="select-cat">
                        <select id="genre" name="genre">
                            <option {{$genre == 'All-Genre' ? 'selected' : ''}}>All-Genre</option>
                            @if(Request::segment(1) == 'popular-movies')
                            @foreach ($genres as $item)
                            <option {{$genre == $item->getId() ? 'selected' : ''}} value="{{$item->getId()}}">{{$item->getName()}}</option>      
                            @endforeach
                            @else
                            <option {{$genre == 'Action' ? 'selected' : ''}} value="Action">Action</option>
                            <option {{$genre == 'Adult' ? 'selected' : ''}} value="Adult">Adult</option>
                            <option {{$genre == 'Adventure' ? 'selected' : ''}} value="Adventure">Adventure</option>
                            <option {{$genre == 'Anime' ? 'selected' : ''}} value="Anime">Anime</option>
                            <option {{$genre == 'Children' ? 'selected' : ''}} value="Children">Children</option>
                            <option {{$genre == 'Comedy' ? 'selected' : ''}} value="Comedy">Comedy</option>
                            <option {{$genre == 'Crime' ? 'selected' : ''}} value="Crime">Crime</option>
                            <option {{$genre == 'DIY' ? 'selected' : ''}} value="DIY">DIY</option>
                            <option {{$genre == 'Drama' ? 'selected' : ''}} value="Drama">Drama</option>
                            <option {{$genre == 'Espionage' ? 'selected' : ''}} value="Espionage">Espionage</option>
                            <option {{$genre == 'Family' ? 'selected' : ''}} value="Family">Family</option>
                            <option {{$genre == 'Fantasy' ? 'selected' : ''}} value="Fantasy">Fantasy</option>
                            <option {{$genre == 'Food' ? 'selected' : ''}} value="Food">Food</option>
                            <option {{$genre == 'History' ? 'selected' : ''}} value="History">History</option>
                            <option {{$genre == 'Horror' ? 'selected' : ''}} value="Horror">Horror</option>
                            <option {{$genre == 'Legal' ? 'selected' : ''}} value="Legal">Legal</option>
                            <option {{$genre == 'Medical' ? 'selected' : ''}} value="Medical">Medical</option>
                            <option {{$genre == 'Music' ? 'selected' : ''}} value="Music">Music</option>
                            <option {{$genre == 'Mystery' ? 'selected' : ''}} value="Mystery">Mystery</option>
                            <option {{$genre == 'Nature' ? 'selected' : ''}} value="Nature">Nature</option>
                            <option {{$genre == 'Romance' ? 'selected' : ''}} value="Romance">Romance</option>
                            <option {{$genre == 'Science-Fiction' ? 'selected' : ''}} value="Science-Fiction">Science-Fiction</option>
                            <option {{$genre == 'Sports' ? 'selected' : ''}} value="Sports">Sports</option>
                            <option {{$genre == 'Supernatural' ? 'selected' : ''}} value="Supernatural">Supernatural</option>
                            <option {{$genre == 'Thriller' ? 'selected' : ''}} value="Thriller">Thriller</option>
                            <option {{$genre == 'Travel' ? 'selected' : ''}} value="Travel">Travel</option>
                            <option {{$genre == 'War' ? 'selected' : ''}} value="War">War</option>
                            <option {{$genre == 'Western' ? 'selected' : ''}} value="Western">Western</option>
                            @endif
                        </select>
                    </div>
                </form>
            </div>
            <div class="sec4-series">
                <div class="sec4-series-content1">
                    <div class="container toggle-container">
                        <div class="row">
                            <div class="sec4-series-content2">
                            @if (Request::segment(1)=='popular-movies')
                                @foreach ($now_playing as $key => $item)
                                    @if ($cnt < 4)
                                    <div class="col-md-3">
                                        <a href="{{'movies/'.Crypt::encrypt($item->getId())}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <img src="{!!$item->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$item->getPosterImage() !!}" class="img-responsive">
                                                </div>
                                                <h3>{{$item->getTitle()}}</h3>
                                                <h4>{{substr(get_object_vars($item->getReleaseDate())['date'], 0,4)}}</h4>
                                            </div>
                                        </a>     
                                    </div>
                                    @else
                                        @break       
                                    @endif
                                    <?php $cnt++; ?>
                                @endforeach
                            @else
                                @foreach ($time['schedule'] as $key => $item)
                                    @if ($key < 4)
                                    <div class="col-md-3">
                                        <a href="{{'tv-series/'.Crypt::encrypt($item['show']['id'])}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <img src="{{'https://'.substr($item['show']['image']['medium'], 7)}}" class="img-responsive">
                                                </div>
                                                <h3>{{$item['show']['name']}}</h3>
                                                <h4>{{substr($item['show']['premiered'], 0,4)}}</h4>
                                            </div>
                                        </a>
                                    </div>
                                    @else 
                                        @break    
                                    @endif
                                @endforeach
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec3-series">
            <div class="sec3-series-content1" style="background-image: url('{!!'frontend/img/book-mid-bg.png'!!}');">
                <div class="container toggle-container">
                    <div class="row">
                        <h2>Editor's Choice</h2>
                        <div class="sec3-series-content2">
                            @foreach ($selected as $key => $item)
                            <?php $item = unserialize($item->data);?>
                                @if($item !== null)
                                    @if($key < 4)
                                        <div class="col-md-3">
                                            <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Request::segment(1) == 'popular-movies' ? Crypt::encrypt($item[0]) : Crypt::encrypt($item[0])}}">
                                                <div class="center-position2">
                                                    <div class="box-shadow-editor">
                                                        @if(Request::segment(1) == 'popular-movies')
                                                        <img src="{!!$item[2] == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$item[2] !!}" class="img-responsive">
                                                        @else
                                                        <img src="{!!$item[2] == '' ? $settings->avatar : $item[2] !!}" class="img-responsive">
                                                        @endif
                                                    </div>
                                                    <h3>{{$item[1]}}</h3>
                                                    <h4>{{substr($item[3], 0, 4)}}</h4>
                                                </div>
                                            </a>
                                        </div>
                                    @else
                                        @break
                                    @endif    
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(Request::segment(1)=='popular-tv-series')
        <div class="sec4-series">
            <div class="sec4-series-content1" style="background-image: url('{!!'frontend/img/top-book-section.png'!!}');">
                <div class="container toggle-container">
                    <div class="row">
                        <div class="sec4-series-content2">
                            @foreach ($selected as $key => $item)
                            <?php $item = unserialize($item->data);?>
                                @if($item !== null)
                                    @if($key >= 4)
                                        <div class="col-md-3">
                                            <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Request::segment(1) == 'popular-movies' ? Crypt::encrypt($item[0]) : Crypt::encrypt($item[0])}}">
                                                <div class="center-position2">
                                                    <div class="box-shadow-editor">
                                                        @if(Request::segment(1) == 'popular-movies')
                                                        <img src="{!!$item[2] == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$item[2] !!}" class="img-responsive">
                                                        @else
                                                        <img src="{!!$item[2] == '' ? $settings->avatar : $item[2] !!}" class="img-responsive">
                                                        @endif
                                                    </div>
                                                    <h3>{{$item[1]}}</h3>
                                                    <h4>{{substr($item[3], 0, 4)}}</h4>
                                                </div>
                                            </a>
                                        </div>
                                    @endif    
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="sec3-series">
            <div class="sec3-series-content1" style="background-image: url('{!!'frontend/img/book-mid-bg.png'!!}');">
                <div class="container toggle-container">
                    <div class="row">
                        <a href="season-premieres" style="position:absolute;right:0;margin-top: 30px; margin-right: 20px;"><button>VIEW ALL</button></a>
                        <h2 class="max-width-425">Season Premieres</h2>
                        <div class="sec3-series-content2">
                        @foreach ($premieres as $key => $item)
                        <?php $item = json_decode($item['encoded_json'], TRUE);?>
                            @if ($key < 4)
                            <div class="col-md-3">
                                <a href="{{'tv-series/'.Crypt::encrypt($item['id'])}}">
                                    <div class="center-position2">
                                        <div class="box-shadow-editor">
                                            <div class="season-tag">
                                                <ul>
                                                    <li>{{strtoupper(date('M', strtotime($item['_embedded']['nextepisode']['airdate'])))}}</li>
                                                    <li>{{date('j', strtotime($item['_embedded']['nextepisode']['airdate']))}}</li>
                                                    <li>{{$item['_embedded']['nextepisode']['airtime']}}</li>
                                                </ul>
                                            </div>
                                            <img src="{{$item['image']['medium'] == '' ? $settings->avatar : 'https://'.substr($item['image']['medium'], 7)}}" class="img-responsive">
                                        </div>
                                        <h3>{{$item['name']}}</h3>
                                        <h4>{{substr($item['premiered'], 0,4)}}</h4>
                                    </div>
                                </a> 
                            </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <?php $count = 0; $displayeditem = [];?>
        <div class="sec4-series">
            <div class="sec4-series-content1" style="background-image: url('{!!'frontend/img/top-book-section.png'!!}');">
                <div class="container toggle-container">
                    <div class="row">
                        @if ($genre != 'All-Genre')
                        <h2>{{Request::segment(1)=='popular-tv-series' ? $genre.' TV Series' : $genre_name.' Movies' }}</h2>
                        @else
                        <h2>{{Request::segment(1)=='popular-tv-series' ? ($keywords == '' ? 'Popular TV Series' : 'We found tv series matching your keyword "'.$keywords.'"') : ($keywords == '' ? 'Popular Movies' : 'We found movies matching your keyword "'.$keywords.'"')}}</h2>                            
                        @endif
                        <div class="sec4-series-content2">
                        @foreach($entries as $key => $value)
                            @if(in_array($key,$displayeditem))
                            @else
                                @if($count <= 3)
                                <div class="col-md-3">
                                    <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Request::segment(1) == 'popular-movies' ? Crypt::encrypt($value->getId()) : Crypt::encrypt($value->id)}}">
                                        <div class="center-position2">
                                            <div class="box-shadow-editor">
                                            @if(Request::segment(1) == 'popular-movies')
                                                <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                            </div>
                                            <h3>{{$value->getTitle()}}</h3>
                                            <h4>{{substr(get_object_vars($value->getReleaseDate())['date'], 0, 4)}}</h4>
                                            @else
                                            <?php $value = unserialize($value['serialize']); ?>
                                                <img src="{{$value['image']['medium'] == '' ? $settings->avatar : 'https://'.substr($value['image']['medium'], 7)}}" class="img-responsive">
                                            </div>
                                            <h3>{{$value['name']}}</h3>
                                            <h4>{{substr($value['premiered'], 0, 4)}}</h4>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <?php $count++; $displayeditem[] = $key;?>
                                @endif
                            @endif
                        @endforeach
                        </div>
                    </div>
                    @if (count($entries) <= 4 && isset($page) && $page != 1)
                    <div class="row">
                        {!! $entries->appends(Input::except('page'))->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @if(count($entries) > 4)
        <div class="sec3-series">
            <div class="sec3-series-content1" style="background-image: url('{!!'frontend/img/book-mid-bg.png'!!}');">
                <div class="container toggle-container">
                    <div class="row">
                        <div class="sec3-series-content2">
                        @foreach($entries as $key => $value)
                            @if(in_array($key,$displayeditem))
                            @else
                                @if($count >= 4 && $count <= 7)
                                <div class="col-md-3">
                                    <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Request::segment(1) == 'popular-movies' ? Crypt::encrypt($value->getId()) : Crypt::encrypt($value->id)}}">
                                        <div class="center-position2">
                                            <div class="box-shadow-editor">
                                            @if(Request::segment(1) == 'popular-movies')
                                                <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                            </div>
                                            <h3>{{$value->getTitle()}}</h3>
                                            <h4>{{substr(get_object_vars($value->getReleaseDate())['date'], 0, 4)}}</h4>
                                            @else
                                            <?php $value = unserialize($value['serialize']); ?>
                                                <img src="{{$value['image']['medium'] == '' ? $settings->avatar : 'https://'.substr($value['image']['medium'], 7)}}" class="img-responsive">
                                            </div>
                                            <h3>{{$value['name']}}</h3>
                                            <h4>{{substr($value['premiered'], 0, 4)}}</h4>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <?php $count++; $displayeditem[] = $key;?>
                                @endif
                            @endif
                        @endforeach
                        </div>
                    </div>
                    <div class="row">
                        {!! $entries->appends(Input::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @if (Request::segment(1) == 'popular-tv-series')
    <div id="sidebar" class="col-md-3 collapse" style="padding:unset;">
        <div class="sidebar-bg">
            <h2>Schedule for<br><span>{{date('F d')}}</span></h2>
            <div class="h3-bg">
                <h3>20:00</h3>
            </div>
            <div class="sched-bg">
                <div class="container-fluid">
                    @foreach ($time['20'] as $item)
                    <div class="row">
                        <div class="col-md-4">
                        <h3>{{$item['airtime']}}<br><span>{{$item['show']['network']['name']}}</span></h3> 
                        </div>
                        <div class="col-md-8">
                            <h4>{{$item['show']['name']}}<br><span>{{$item['name']}}</span></h4>
                        </div>
                    </div>
                    @endforeach
                </div>    
            </div>
            <div class="h3-bg">
                <h3>21:00</h3>
            </div>
            <div class="sched-bg">
                <div class="container-fluid">
                    @foreach ($time['21'] as $item)
                    <div class="row">
                        <div class="col-md-4">
                        <h3>{{$item['airtime']}}<br><span>{{$item['show']['network']['name']}}</span></h3> 
                        </div>
                        <div class="col-md-8">
                            <h4>{{$item['show']['name']}}<br><span>{{$item['name']}}</span></h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="h3-bg">
                <h3>22:00</h3>
            </div>
            <div class="sched-bg">
                <div class="container-fluid">
                    @foreach ($time['22'] as $item)
                    <div class="row">
                        <div class="col-md-4">
                        <h3>{{$item['airtime']}}<br><span>{{$item['show']['network']['name']}}</span></h3> 
                        </div>
                        <div class="col-md-8">
                            <h4>{{$item['show']['name']}}<br><span>{{$item['name']}}</span></h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="h3-bg">
                <h3>23:00</h3>
            </div>
            <div class="sched-bg">
                <div class="container-fluid">
                    @foreach ($time['23'] as $item)
                    <div class="row">
                        <div class="col-md-4">
                        <h3>{{$item['airtime']}}<br><span>{{$item['show']['network']['name']}}</span></h3> 
                        </div>
                        <div class="col-md-8">
                            <h4>{{$item['show']['name']}}<br><span>{{$item['name']}}</span></h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop
@section('js')
<script type="text/javascript">
    if(document.location.href.substr(document.location.href.lastIndexOf('/') + 1).split('?')[0] == 'popular-movies'){
        $('.form').find('button').click(function(){
            $('#genre').val('All-Genre');
        });
    }
    $('#genre').change(function(){
       $('.form').submit();
    });
    var state = true;
    $('#toggle-sidebar').click(function(){
        $('#toggle-sidebar').css({"cursor": "wait","pointer-events": "none"});
        if (state){
            $(".toggle-container").toggleClass("container container-fluid");
            $("#content-inner").toggleClass("col-md-12 col-md-9").promise().done(function(){
                $("#sidebar").fadeIn(500);
                $("#toggle-sidebar").html("<button style='width: 170px;'>HIDE SCHEDULES</button>");
                state = !state;
                $('#toggle-sidebar').css({"cursor": "pointer","pointer-events": "auto"});
            });
        }else{
            $("#sidebar").fadeOut(500).promise().done(function(){
                $("#content-inner").toggleClass("col-md-12 col-md-9");
                $("#toggle-sidebar").html("<button style='width: 170px;'>VIEW SCHEDULES</button>");
                $(".toggle-container").toggleClass("container container-fluid");
                state = !state;
                $('#toggle-sidebar').css({"cursor": "pointer","pointer-events": "auto"});
            });
        }
    });
</script>
@stop