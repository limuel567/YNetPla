@extends('frontend.layout')
@section('title','YNetPla')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="padding: 0;">
            <?php $count = 0; $displayeditem = []; $cnt = 0;?>
            <div class="container-fluid latest-banner" style="background-image: url('frontend/img/latest-banner.png');">
                <h2>{{Request::segment(1)=='season-premieres' ? 'Season Premieres' : ($keywords == '' ? 'Coming Soon Movies' : 'We found movies matching your keyword "'.$keywords.'"')}}</h2>
            </div>
            <div class="container-fluid search-latest-section" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/search-bg.png' : 'frontend/img/top-book-section.png' !!}');">
                <div class="sec4-series">
                    <div class="sec4-series-content1">
                        <div class="container">
                            <div class="row">
                                <div class="sec4-series-content2">
                                @foreach($entries as $key => $value)
                                    @if(in_array($key,$displayeditem))
                                    @else
                                        @if($count <= 3)
                                        <div class="col-md-3">
                                            @if(Request::segment(1)=='coming-soon-movies')
                                            <a href="{{'movies/'.Crypt::encrypt($value->getId())}}">
                                                <div class="center-position2">
                                                    <div class="box-shadow-editor">
                                                        <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                                    </div>
                                                    <h3>{{$value->getTitle()}}</h3>
                                                    <h4>2018</h4>
                                                </div>
                                            </a>
                                            @else
                                            <?php $value = json_decode($value->encoded_json, TRUE);?>
                                            <a href="{{'tv-series/'.Crypt::encrypt($value['id'])}}">
                                                <div class="center-position2">
                                                    <div class="box-shadow-editor">
                                                        <div class="season-tag">
                                                            <ul>
                                                                <li>{{strtoupper(date('M', strtotime($value['_embedded']['nextepisode']['airdate'])))}}</li>
                                                                <li>{{date('j', strtotime($value['_embedded']['nextepisode']['airdate']))}}</li>
                                                                <li>{{$value['_embedded']['nextepisode']['airtime']}}</li>
                                                            </ul>
                                                        </div>
                                                        <img src="{{$value['image']['medium'] ? 'https://'.substr($value['image']['medium'], 7) : $settings->avatar}}" class="img-responsive">
                                                    </div>
                                                    <h3>{{$value['name']}}</h3>
                                                    <h4>{{substr($value['premiered'], 0,4)}}</h4>
                                                </div>
                                            </a> 
                                            @endif
                                        </div>
                                        <?php $count++; $displayeditem[] = $key;?>
                                        @else
                                            @break
                                        @endif
                                    @endif
                                @endforeach
                                </div>
                            </div>
                            @if (count($entries) <= 4 && $entries->currentPage() != 1)
                            <div class="row" style="display: flex;justify-content: center;">
                                {!! $entries->appends(Input::except('page'))->render() !!}
                            </div>   
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if (count($entries) > 4)
            <div class="sec3-series">
                <div class="sec3-series-content1" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/mid-section-bg.png' : 'frontend/img/book-mid-bg.png' !!}');">
                    <div class="container">
                        <div class="row">
                            <div class="sec3-series-content2">
                            @foreach($entries as $key => $value)
                                @if(in_array($key,$displayeditem))
                                @else
                                    @if($count >= 4 && $count <= 7)
                                    <div class="col-md-3">
                                        @if(Request::segment(1)=='coming-soon-movies')
                                        <a href="{{'movies/'.Crypt::encrypt($value->getId())}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                                </div>
                                                <h3>{{$value->getTitle()}}</h3>
                                                <h4>2018</h4>
                                            </div>
                                        </a>
                                        @else
                                        <?php $value = json_decode($value->encoded_json, TRUE);?>
                                        <a href="{{'tv-series/'.Crypt::encrypt($value['id'])}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <div class="season-tag">
                                                        <ul>
                                                            <li>{{strtoupper(date('M', strtotime($value['_embedded']['nextepisode']['airdate'])))}}</li>
                                                            <li>{{date('j', strtotime($value['_embedded']['nextepisode']['airdate']))}}</li>
                                                            <li>{{$value['_embedded']['nextepisode']['airtime']}}</li>
                                                        </ul>
                                                    </div>
                                                    <img src="{{$value['image']['medium'] ? 'https://'.substr($value['image']['medium'], 7) : $settings->avatar}}" class="img-responsive">
                                                </div>
                                                <h3>{{$value['name']}}</h3>
                                                <h4>{{substr($value['premiered'], 0,4)}}</h4>
                                            </div>
                                        </a> 
                                        @endif
                                    </div>
                                    <?php $count++; $displayeditem[] = $key;?>
                                    @endif
                                @endif
                            @endforeach
                            </div>
                        </div>
                        @if (count($entries) <= 8 && $entries->currentPage() != 1)
                        <div class="row" style="display: flex;justify-content: center;">
                            {!! $entries->appends(Input::except('page'))->render() !!}
                        </div>   
                        @endif
                    </div>
                </div>
            </div>    
            @endif
            @if (count($entries) > 8)
            <div class="sec4-series">
                <div class="sec4-series-content1" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/book-mid-bg.png' : 'frontend/img/popular-tv-bg.png'!!}');">
                    <div class="container">
                        <div class="row">
                            <div class="sec4-series-content2">
                            @foreach($entries as $key => $value)
                                @if(in_array($key,$displayeditem))
                                @else
                                    @if($count >= 8 && $count <= 11)
                                    <div class="col-md-3">
                                        @if(Request::segment(1)=='coming-soon-movies')
                                        <a href="{{'movies/'.Crypt::encrypt($value->getId())}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                                </div>
                                                <h3>{{$value->getTitle()}}</h3>
                                                <h4>2018</h4>
                                            </div>
                                        </a>
                                        @else
                                        <?php $value = json_decode($value->encoded_json, TRUE);?>
                                        <a href="{{'tv-series/'.Crypt::encrypt($value['id'])}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <div class="season-tag">
                                                        <ul>
                                                            <li>{{strtoupper(date('M', strtotime($value['_embedded']['nextepisode']['airdate'])))}}</li>
                                                            <li>{{date('j', strtotime($value['_embedded']['nextepisode']['airdate']))}}</li>
                                                            <li>{{$value['_embedded']['nextepisode']['airtime']}}</li>
                                                        </ul>
                                                    </div>
                                                    <img src="{{$value['image']['medium'] ? 'https://'.substr($value['image']['medium'], 7) : $settings->avatar}}" class="img-responsive">
                                                </div>
                                                <h3>{{$value['name']}}</h3>
                                                <h4>{{substr($value['premiered'], 0,4)}}</h4>
                                            </div>
                                        </a> 
                                        @endif
                                    </div>
                                    <?php $count++; $displayeditem[] = $key;?>
                                    @endif
                                @endif
                            @endforeach
                            </div>
                        </div>
                        @if (count($entries) <= 12 && $entries->currentPage() != 1)
                        <div class="row" style="display: flex;justify-content: center;">
                            {!! $entries->appends(Input::except('page'))->render() !!}
                        </div>   
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @if (count($entries) > 12)
            <div class="sec3-series">
                <div class="sec3-series-content1" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/mid-section-bg.png' : 'frontend/img/book-mid-bg.png' !!}');">
                    <div class="container">
                        <div class="row">
                            <div class="sec3-series-content2">
                            @foreach($entries as $key => $value)
                                @if(in_array($key,$displayeditem))
                                @else
                                    @if($count >= 12 && $count <= 15)
                                    <div class="col-md-3">
                                        @if(Request::segment(1)=='coming-soon-movies')
                                        <a href="{{'movies/'.Crypt::encrypt($value->getId())}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                                </div>
                                                <h3>{{$value->getTitle()}}</h3>
                                                <h4>2018</h4>
                                            </div>
                                        </a>
                                        @else
                                        <?php $value = json_decode($value->encoded_json, TRUE);?>
                                        <a href="{{'tv-series/'.Crypt::encrypt($value['id'])}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <div class="season-tag">
                                                        <ul>
                                                            <li>{{strtoupper(date('M', strtotime($value['_embedded']['nextepisode']['airdate'])))}}</li>
                                                            <li>{{date('j', strtotime($value['_embedded']['nextepisode']['airdate']))}}</li>
                                                            <li>{{$value['_embedded']['nextepisode']['airtime']}}</li>
                                                        </ul>
                                                    </div>
                                                    <img src="{{$value['image']['medium'] ? 'https://'.substr($value['image']['medium'], 7) : $settings->avatar}}" class="img-responsive">
                                                </div>
                                                <h3>{{$value['name']}}</h3>
                                                <h4>{{substr($value['premiered'], 0,4)}}</h4>
                                            </div>
                                        </a> 
                                        @endif
                                    </div>
                                    <?php $count++; $displayeditem[] = $key;?>
                                    @endif
                                @endif
                            @endforeach
                            </div>
                        </div>
                        @if (count($entries) <= 16 && $entries->currentPage() != 1)
                        <div class="row">
                            {!! $entries->appends(Input::except('page'))->render() !!}
                        </div>   
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @if (count($entries) > 16)
            <div class="sec4-series">
                <div class="sec4-series-content1" style="background-image: url('{!! Request::segment(1) == 'latest-and-hottest' ? 'frontend/img/book-mid-bg.png' : 'frontend/img/pagination-bg.png'!!}');">
                    <div class="container">
                        <div class="row">
                            <div class="sec4-series-content2">
                            @foreach($entries as $key => $value)
                                @if(in_array($key,$displayeditem))
                                @else
                                    @if($count >= 16 && $count <= 19)
                                    <div class="col-md-3">
                                        @if(Request::segment(1)=='coming-soon-movies')
                                        <a href="{{'movies/'.Crypt::encrypt($value->getId())}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <img src="{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}" class="img-responsive">
                                                </div>
                                                <h3>{{$value->getTitle()}}</h3>
                                                <h4>2018</h4>
                                            </div>
                                        </a>
                                        @else
                                        <?php $value = json_decode($value->encoded_json, TRUE);?>
                                        <a href="{{'tv-series/'.Crypt::encrypt($value['id'])}}">
                                            <div class="center-position2">
                                                <div class="box-shadow-editor">
                                                    <div class="season-tag">
                                                        <ul>
                                                            <li>{{strtoupper(date('M', strtotime($value['_embedded']['nextepisode']['airdate'])))}}</li>
                                                            <li>{{date('j', strtotime($value['_embedded']['nextepisode']['airdate']))}}</li>
                                                            <li>{{$value['_embedded']['nextepisode']['airtime']}}</li>
                                                        </ul>
                                                    </div>
                                                    <img src="{{$value['image']['medium'] ? 'https://'.substr($value['image']['medium'], 7) : $settings->avatar}}" class="img-responsive">
                                                </div>
                                                <h3>{{$value['name']}}</h3>
                                                <h4>{{substr($value['premiered'], 0,4)}}</h4>
                                            </div>
                                        </a> 
                                        @endif
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
    </div>    
</div>

@stop