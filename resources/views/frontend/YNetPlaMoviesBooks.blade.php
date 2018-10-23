@extends('frontend.layout')
@section('title','YNetPla')
@section('content')
<div class="container-fluid latest-banner" style="background-image: url('frontend/img/latest-banner.png');">
    <h2>Popular {!! Request::segment(1) == 'popular-movies' ? 'Movies' : 'TV Series' !!}</h2>
</div>
<?php $count = 0; $displayeditem = [];?>
<div class="container-fluid search-latest-section" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/search-bg.png' : 'frontend/img/top-book-section.png' !!}');">
    <div class="row top-holder">
        <a href="popular-movies"><button>MOVIES</button></a>
        <a href="popular-tv-series"><button>TV SERIES</button></a>
    <form action="{{URL(Request::segment(1))}}" method="get" class="form">
        <input name="keywords" type="text" value="{!! $keywords != '' ? $keywords : '' !!}" placeholder="Search {!! Request::segment(1) == 'popular-movies' ? 'Movies' : 'TV Series' !!}">
        <button><i class="fa fa-search"></i></button>
    </form>
    </div>
    <div class="container">
        <div class="row latest-movie-holder">
            @foreach($entries as $key => $value)
                @if(in_array($key,$displayeditem))
                @else
                    @if($count <= 3)
                    <div class="col-md-3">
                        <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Crypt::encrypt($value->getId())}}">
                            <div class="img-holder">
                                <div class="shadow-inset" style="background-image: url('{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/original'.$value->getPosterImage() !!}');"></div>
                            </div>
                            <h2>{{Request::segment(1) == 'popular-movies' ? $value->getTitle() : $value->getName()}}</h2>
                            <p>{{substr(get_object_vars(Request::segment(1) == 'popular-movies' ? $value->getReleaseDate() : $value->getFirstAirDate())['date'], 0, 4)}}</p>
                        </a>
                    </div>
                    <?php $count++; $displayeditem[] = $key;?>
                    @endif
                @endif
            @endforeach
        </div>
        @if(count($entries) <= 4)
        <div class="row page-holder">
            {!! $entries->appends(Input::except('page'))->render() !!}
        </div>
        @endif
    </div>
</div>
@if(count($entries) > 4)
<div class="container-fluid latest-mid-section" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/mid-section-bg.png' : 'frontend/img/book-mid-bg.png' !!}');">
    <div class="container">
        <div class="row latest-movie-holder2">
            @foreach($entries as $key => $value)
                @if(in_array($key,$displayeditem))
                @else
                    @if($count >= 4 && $count <= 7)
                    <div class="col-md-3">
                            <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Crypt::encrypt($value->getId())}}">
                            <div class="img-holder">
                                <div class="shadow-inset" style="background-image: url('{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/original'.$value->getPosterImage() !!}');"></div>
                            </div>
                            <h2>{{Request::segment(1) == 'popular-movies' ? $value->getTitle() : $value->getName()}}</h2>
                            <p>{{substr(get_object_vars(Request::segment(1) == 'popular-movies' ? $value->getReleaseDate() : $value->getFirstAirDate())['date'], 0, 4)}}</p>
                        </a>
                    </div>
                    <?php $count++; $displayeditem[] = $key;?>
                    @endif
                @endif
            @endforeach
        </div>
        @if(count($entries) <= 8)
        <div class="row page-holder">
            {!! $entries->appends(Input::except('page'))->render() !!}
        </div>
        @endif
    </div>
</div>
@endif
@if(count($entries) > 8)
<div class="container-fluid pagination-section" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/pagination-bg.png' : 'frontend/img/pagination-book.png' !!}');">
    <div class="container">
        <div class="row latest-movie-holder">
            @foreach($entries as $key => $value)
                @if(in_array($key,$displayeditem))
                @else
                    @if($count >= 8 && $count <= 11)
                    <div class="col-md-3">
                            <a href="{!! Request::segment(1) == 'popular-movies' ? 'movies/' : 'tv-series/' !!}{{Crypt::encrypt($value->getId())}}">
                            <div class="img-holder">
                                <div class="shadow-inset" style="background-image: url('{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/original'.$value->getPosterImage() !!}');"></div>
                            </div>
                            <h2>{{Request::segment(1) == 'popular-movies' ? $value->getTitle() : $value->getName()}}</h2>
                            <p>{{substr(get_object_vars(Request::segment(1) == 'popular-movies' ? $value->getReleaseDate() : $value->getFirstAirDate())['date'], 0, 4)}}</p>
                        </a>
                    </div>
                    <?php $count++; $displayeditem[] = $key;?>
                    @endif
                @endif
            @endforeach
        </div>
        <div class="row page-holder">
            {!! $entries->appends(Input::except('page'))->render() !!}
        </div>
    </div>
</div>
@endif
@stop
