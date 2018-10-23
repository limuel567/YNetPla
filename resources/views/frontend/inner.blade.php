@extends('frontend.layout')
@section('title','YNetPla')
@section('content')
<?php $cnt = 0; ?>
<div class="container-fluid books-banner search-books-section-edit" style="background-image: url('../frontend/img/books-banner.png');">
    <form action="{{URL('popular-'.Request::segment(1))}}" method="get" class="form">
        <input name="keywords" type="text" value="{!! $keywords != '' ? $keywords : '' !!}" placeholder="Search {!! Request::segment(1) == 'movies' ? 'Movies' : 'TV Series' !!}">
        <button><i class="fa fa-search"></i></button>
    </form>
</div>
<div class="container-fluid search-books-section" style="background-image: url('../frontend/img/top-book-section.png');">
    <div class="clearfix" style="min-height: 70px;">
        {!! Request::segment(1)=='movies' ?  '<a href="../coming-soon-movies"><button id="toggle-right-sidebar">COMING SOON MOVIES</button></a>' : '<button id="toggle-right-sidebar">VIEW SCHEDULES</button>' !!}
    </div>
    <div class="container">
        <div class="row" id="content-main">
            <div id="content-inner" class="col-md-12">
                @if(Request::segment(1) == 'tv-series')
                <div id="videotitle" class="collapse">
                    <h2>{{$details[0]->name}}:</h2>
                </div>
                @endif
                <div id="left-part" class="col-md-5">
                    <div class="tv-series-bg">
                        <div id="imgholdertv" class="img-holder-tv">
                        @if(Request::segment(1) == 'movies')
                        <div id="shadow" class="shadow-inset" style="background-image: url('{{$details->getPosterPath() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w500'.$details->getPosterPath() }}');"></div>
                        @else
                        <div id="shadow" class="shadow-inset" style="background-image: url('{{$details[0]->originalImage == '' ? $settings->avatar : 'https://'.substr($details[0]->originalImage, 7) }}');"></div>
                        @endif
                        </div>
                    </div>
                    @if (Request::segment(1) == 'tv-series')
                    <div id="episodesholder" class="episodes-holder">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                            <!-- Wrapper for slides -->
                            <?php $current_date = date('Y-m-d');?> 
                            <div class="carousel-inner">
                                @foreach ($details[3] as $key => $season)
                                    @if(($season->premiereDate <= $current_date) && $season->premiereDate != null)
                                    <div class="item {{$key == $latest_season-1 ? 'active' : ''}}">
                                        <h2>Season {{$season->number}}: Episodes</h2>
                                        <div class="episode-name">
                                            <h3>Episode Names</h3>
                                        </div>
                                        <div class="episode-list">
                                            <ul>
                                                @foreach ($details[2] as $key => $episode)
                                                    @if($episode->season === $season->number)
                                                    <li>Episode {{$episode->number}}: <span>{{$episode->name}}</span></li>    
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>    
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="episodes-arrow">
                            <ul>
                                <li><a href="#myCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a></li>
                                <li><a href="#myCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div>
                    </div>      
                    @endif
                </div>
                <div id="center-part" class="col-md-7">
                    <div class="movie-title">
                        @if(Request::segment(1) == 'tv-series')
                        <h2><span id="title-toggle">{{$details[0]->name}}: </span>Season {{$latest_season}} Episode {{$latest_episode}}</h2>
                        <h3>{{$details[0]->name}} Trailer:</h3>
                        <div class="movie-holder">
                            <?php $video_link = App\Models\TvMaze::find($details[0]->id); ?>
                            @if ($video_link['trailer'])
                                @if ($video_link['video_host'] == 0)
                            <iframe src="https://www.youtube.com/embed/{{$video_link['trailer'] ? $video_link['trailer'] : 'bkifvuuIrXs'}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="movie-play" id="movieplay"></iframe>
                                @else 
                            <iframe src="https://player.vimeo.com/video/{{$video_link['trailer'] ? $video_link['trailer'] : '269898730'}}?transparent=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="movie-play" id="movieplay"></iframe>
                                @endif
                            @else 
                            <iframe src="https://www.youtube.com/embed/bkifvuuIrXs" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="movie-play" id="movieplay"></iframe>
                            @endif    
                        </div>
                        @else
                        <h2>{{$details->getTitle()}}</h2>
                        <h3>{{$details->getTitle()}} Trailer:</h3>
                        <div class="movie-holder">
                            <?php $genres= '';?>
                            @foreach($details->getGenres() as $genre)
                                <?php $genres = $genres.$genre->getName().', '; ?>
                            @endforeach
                            @if(!$genres)
                                <?php $genres = 'No Genre'; ?>
                            @endif
                            <?php $video_link = App\Models\MovieTMDB::find($details->getId()); ?>
                            @if ($video_link)
                                @if ($video_link['video_host'] == 0)
                            <iframe src="https://www.youtube.com/embed/{{$video_link['trailer'] ? $video_link['trailer'] : 'bkifvuuIrXs'}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="movie-play" id="movieplay"></iframe>
                                @else 
                            <iframe src="https://player.vimeo.com/video/{{$video_link['trailer'] ? $video_link['trailer'] : '269898730'}}?transparent=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="movie-play" id="movieplay"></iframe>
                                @endif
                            @else 
                            <iframe src="https://www.youtube.com/embed/{{$videos ? $videos : 'bkifvuuIrXs'}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="movie-play" id="movieplay"></iframe>
                            @endif 
                        </div>
                        @endif
                        <div id="movieinfoholder">
                            @if(Request::segment(1) == 'tv-series')    
                            <h3>{{substr($details[0]->premiered, 0, 4)}}<br>{{implode(", ",$details[0]->genres)}}</h3>
                            <div class="movie-des">
                                <p>{{$details[0]->summary}}</p>
                            </div>
                            @else
                            <h3>{{substr(get_object_vars($details->getReleaseDate())['date'], 0, 4)}}<br>{{rtrim($genres,', ')}}</h3>
                            <div class="movie-des">
                                <p>{{$details->getOverview()}}</p>
                            </div>
                            @endif
                        </div>
                        {{-- <div class="link-ep">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <div class="num-pos">
                                    <h3>Episodes</h3>
                                    <ul class="episode-num">
                                        <li><i class="fa fa-chevron-left"></i></li>
                                        <li class="active">1</li>
                                        <li>2</li>
                                        <li>3</li>
                                        <li>4</li>
                                        <li>5</li>
                                        <li>6</li>
                                        <li>7</li>
                                        <li>8</li>
                                        <li>9</li>
                                        <li>10</li>
                                        <li><i class="fa fa-chevron-right"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            @if (Request::segment(1) == 'tv-series')
            <div id="viewschedule" class="view-schedule">
                <button id="schedule">VIEW DETAILED SCHEDULE</button>
            </div>
            <div id="sidebar" class="col-md-3 collapse">
                <div class="sidebar-bg">
                    <h2>Schedule for<br><span>{{date('F d')}}</span></h2>
                    <div class="h3-bg">
                        <h3>20:00</h3>
                    </div>
                    <div class="sched-bg">
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
                    <div class="h3-bg">
                        <h3>21:00</h3>
                    </div>
                    <div class="sched-bg">
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
                    <div class="h3-bg">
                        <h3>22:00</h3>
                    </div>
                    <div class="sched-bg">
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
                    <div class="h3-bg">
                        <h3>23:00</h3>
                    </div>
                    <div class="sched-bg">
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
            @endif
        </div>
    </div>
</div>
{{-- <section class="sec1-series">
    <div class="sec1-series-content1" style="background-image: url('../frontend/img/tv-series.jpg');">
        <div class="container">
            <div class="row">
                <h2>Editor's Choice</h2>
                <div class="sec1-series-content2">
                    <div class="col-md-3">
                        <div class="center-position2">
                            <div class="box-shadow-editor">
                                <img src="../frontend/img/editor-1.png">
                            </div>
                            <h3>DEADPOOL 2</h3>
                            <h4>2018</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="center-position2">
                            <div class="box-shadow-editor">
                                <img src="../frontend/img/editor-2.png">
                            </div>
                            <h3>ant man and the wasp</h3>
                            <h4>2018</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="center-position2">
                            <div class="box-shadow-editor">
                                <img src="../frontend/img/editor-3.png">
                            </div>
                            <h3>uncle drew</h3>
                            <h4>2018</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="center-position2">
                            <div class="box-shadow-editor">
                                <img src="../frontend/img/editor-4.png">
                            </div>
                            <h3>justice league</h3>
                            <h4>2018</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-soon-holder">
        <button class="btn-coming-soon">coming soon movies</button>
    </div>
</section> --}}
@if (Request::segment(1) == 'tv-series')
    @if(count($details[1]) !== 0)
    <section class="sec2-series">
        <div class="sec2-series-bg" style="background-image: url('../frontend/img/tv-series.jpg');">
            <div class="container">
            <div class="row">
                    <h2>Cast</h2>
                        <div class="sec2-series-content1">
                            <div class="slider-area">
                                <div class="owl-carousel owl-theme">
                                    @foreach ($details[1] as $cast)
                                    <div class="item">
                                        <div class="center-position">
                                            <div class="box-shadow-cast">
                                                <img src="{{$cast[1]->image['medium'] == '' ? 'https://'.substr($cast[0]->image['medium'], 7) : 'https://'.substr($cast[1]->image['medium'], 7)}}">
                                            </div>
                                            <div style="width: 197px;">
                                                <h2>{{$cast[0]->name}}</h2>
                                                <h3><span>{{$details[0]->type == 'Animation' ? 'voices' : 'as'}}</span> {{$cast[1]->name}}</h3> 
                                            </div>
                                        </div>
                                    </div>    
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    @endif
@endif
<section {{Request::segment(1) == 'movies' ? 'class=sec3-series' : (count($details[1]) == 0 ? 'class=sec3-series' : 'class=sec4-series')}}>
<div {{Request::segment(1) == 'movies' ? 'class=sec3-series-content1' : (count($details[1]) == 0 ? 'class=sec3-series-content1' : 'class=sec4-series-content1')}} style="background-image: url('{{Request::segment(1)== 'tv-series' ? (count($details[1]) == 0 ? '../frontend/img/tv-series.jpg' : '../frontend/img/top-book-section.png') : '../frontend/img/tv-series.jpg'}}');">
        <div class="container">
            <div class="row">
                <h2>Editor's Choice</h2>
                <div {{Request::segment(1) == 'movies' ? 'class=sec3-series-content2' : (count($details[1]) == 0 ? 'class=sec3-series-content2' : 'class=sec4-series-content2')}}>
                @foreach ($selected as $key => $item)
                <?php $item = unserialize($item->data);?>
                    @if($item !== null)
                        @if($key < 4)
                            <div class="col-md-3">
                                <a href="{!! Crypt::encrypt($item[0]) !!}">
                                    <div class="center-position2">
                                        <div class="box-shadow-editor">
                                            @if(Request::segment(1) == 'movies')
                                            <img src="{!!$item[2] == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$item[2] !!}" class="img-responsive">
                                            @else
                                            <img src="{!!$item[2] == '' ? $settings->avatar : 'https://'.substr($item[2], 7) !!}" class="img-responsive">
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
</section>
<section {{Request::segment(1) == 'tv-series' ? (count($details[1]) == 0 ? 'class=sec4-series' : 'class=sec3-series') : 'class=sec4-series'}}>
    <div {{Request::segment(1) == 'tv-series' ? (count($details[1]) == 0 ? 'class=sec4-series-content1' : 'class=sec3-series-content1') : 'class=sec4-series-content1'}} style="background-image: url('{{Request::segment(1)== 'movies' ? '../frontend/img/top-book-section.png' : (count($details[1]) == 0 ? '../frontend/img/top-book-section.png' : '../frontend/img/tv-series.jpg')}}');">
        <div class="container">
            <div class="row">
                <h2>{{Request::segment(1) == 'tv-series' ? 'Popular Shows Airing Tonight' : 'Now Playing Movies'}}</h2>
                <div {{Request::segment(1) == 'tv-series' ? (count($details[1]) == 0 ? 'class=sec4-series-content2' : 'class=sec3-series-content2') : 'class=sec4-series-content2'}}>
                    @if (Request::segment(1)=='movies')
                        @foreach ($now_playing as $key => $item)
                            @if ($cnt < 4)
                            <a href="{{Crypt::encrypt($item->getId())}}">
                                <div class="col-md-3">
                                    <div class="center-position2">
                                        <div class="box-shadow-editor">
                                            <img src="{!!$item->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$item->getPosterImage() !!}" class="img-responsive">
                                        </div>
                                        <h3>{{$item->getTitle()}}</h3>
                                        <h4>{{substr(get_object_vars($item->getReleaseDate())['date'], 0,4)}}</h4>
                                    </div>
                                </div>
                            </a> 
                            @else
                                @break       
                            @endif
                            <?php $cnt++; ?>
                        @endforeach
                    @else
                        @foreach ($time['schedule'] as $key => $item)
                            @if ($key < 4)
                            <a href="{{Crypt::encrypt($item['show']['id'])}}">
                                <div class="col-md-3">
                                    <div class="center-position2">
                                        <div class="box-shadow-editor">
                                            <img src="{{'https://'.substr($item['show']['image']['medium'], 7)}}" class="img-responsive">
                                        </div>
                                        <h3>{{$item['show']['name']}}</h3>
                                        <h4>{{substr($item['show']['premiered'], 0,4)}}</h4>
                                    </div>
                                </div>
                            </a>        
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('js')
<script type="text/javascript">
     $('#schedule').click(function(){
        window.location.replace('{{URL('/schedule')}}');
    });
    var state = true;
    $('#toggle-right-sidebar').click(function(){
        $("#content-inner").toggleClass("col-md-12 col-md-9", 500).promise().done(function(){
            if ( state ) {
                $("#sidebar").fadeIn("slow");
                $("#title-toggle").css('display', 'none');
                $( "#imgholdertv" ).animate({
                height: 315
                }, 1000 );
                $( "#movieplay" ).animate({
                height: 330
                }, 1000 );
                $( "#movieinfoholder" ).animate({
                marginTop: '-65px'
                }, 1000 );
                if({!!Request::segment(1)!='movies'!!}){
                    $("#toggle-right-sidebar").prop('value', 'Hide');
                    document.getElementById('episodesholder').style.display = 'block';
                    document.getElementById('viewschedule').style.display = 'block';
                    $("#toggle-right-sidebar").html('HIDE SCHEDULES');
                } 
            }else {
                $("#sidebar").fadeOut("slow");
                $("#title-toggle").css('display', 'unset');
                $( "#imgholdertv" ).animate({
                height: 456
                }, 1000 );
                $( "#movieplay" ).animate({
                height: 392
                }, 1000 );
                $( "#movieinfoholder" ).animate({
                marginTop: '0px'
                }, 1000 );
                document.getElementById('episodesholder').style.display = 'none';
                document.getElementById('viewschedule').style.display = 'none';
                $("#toggle-right-sidebar").html('VIEW SCHEDULES');
            }      
            state = !state;    
        });
        $("#videotitle").toggleClass("collapse");
        $("#left-part").css("padding-right", "30px");
        $("#left-part").css("padding-left", "30px");
        $("#center-part").css("padding-left", "0px");
        $("#center-part").css("padding-right", "0px");
        $("#sidebar").css("padding-right", "0px");
        $("#sidebar").css("padding-left", "0px");
    });
     var owl = $('.slider-area .owl-carousel');
            owl.owlCarousel({
                nav: true,
                autoplay:false,
                navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                loop: true,
                responsive: {
                    0: {
                        items: 1,
                        loop: false
                    },
                    767:{
                        items:3,
                        loop: false
                    },
                    1000: {
                        items: 5,
                        nav: true,
                        autoplay:true,
                        loop: false
                    }
                }
            });
</script>
@stop
