@extends('frontend.layout')
@section('title','YNetPla')
@section('content')
{{-- {{ dd(get_defined_vars()['__data']) }} --}}
<div id="content" class="container-fluid home-banner" style="background-image: url('{{$page_content->section_first[0]->content}}');">
    <div class="banner-content container">
        <img src="{{$page_content->section_first[1]->content}}" alt=""><br>
        <a href="#"><button>LEARN MORE</button></a>
    </div>
</div>
<div class="subscription-section container-fluid" style="background-image: url('{{$page_content->section_second[4]->content}}');">
    <div class="row">
        <div class="trial-holder">
            <img src="{{$page_content->section_second[1]->content}}" alt="" class="hand-image">
            <h2>{{$subscription[2]->subscription_period}}</h2>
        </div>
        <div class="left-margin-hand">
            <div class="col-md-12">
            <h2 class="plans-header">{{$page_content->section_second[0]->content}}</h2>
                <div class="row">
                    @foreach($subscription as $key => $value)
                    @if($key != 2)
                    <div class="col-md-6">
                        <div class="member">
                            <img src="{{$value->id == 1 ? $page_content->section_second[2]->content : $page_content->section_second[3]->content }}" alt="">
                            <h2>{{$value->name}}<br><span>({{$value->subscription_type == 0 ? 'Free' : ($value->subscription_type == 1 ? 'Trial' : 'Pay')}})</span></h2>
                            @foreach(unserialize($value->description) as $description)
                                @if($description != '')
                                <p style="position: relative;"><i class="fa fa-circle" style="font-size: 8px;position: absolute; left: 20px; top: 2px;"></i> {{$description}}</p>
                                @endif
                            @endforeach
                            <a><button>SELECT</button></a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>    
    </div>
</div>
<div class="popular-section">
    <div class="container-fluid popular-h" style="background-image: url('{{$page_content->section_third[1]->content}}');">
        <div class="popular-category">
            <a href="popular-movies" class="pull-right"><button>VIEW ALL</button></a>
            <h2>{{$page_content->section_third[0]->content}}</h2>
            <div class="container">
                <div class="row">
                    <?php $count = 0; ?>
                    @foreach($movie as $key => $value)
                        @if($count <= 3)
                        <div class="col-md-3">
                            <a href="movies/{{Crypt::encrypt($value->getId())}}">
                                <div class="img-holder">
                                    <div class="shadow-inset" style="background-image: url('{!!$value->getPosterImage() == '' ? $settings->avatar : '//image.tmdb.org/t/p/w342'.$value->getPosterImage() !!}');"></div>
                                </div>
                                <h3>{{$value->getTitle()}}</h3>
                                <p>{{substr(get_object_vars($value->getReleaseDate())['date'], 0, 4)}}</p>
                            </a>
                        </div>
                        <?php $count++; ?>
                        @else 
                            @break
                        @endif
                    @endforeach
                </div> 
            </div>    
        </div>
    </div>
    <div class="container-fluid popular-h2" style="background-image: url('{{$page_content->section_fourth[1]->content}}');">
        <div class="popular-category">
            <a href="popular-tv-series" class="pull-right"><button>VIEW ALL</button></a>
            <h2>{{$page_content->section_fourth[0]->content}}</h2>
            <div class="container">
                <div class="row">
                    <?php $count = 0; ?>
                    @foreach($stored_shows as $key => $value)
                        <?php $value = unserialize($value['serialize']); ?>
                        @if($count <= 3)
                        <div class="col-md-3">
                            <a href="tv-series/{{Crypt::encrypt($value['id'])}}">
                                <div class="img-holder">
                                    <div class="shadow-inset" style="background-image: url('{!!$value['image']['medium'] == '' ? $settings->avatar : 'https://'.substr($value['image']['medium'], 7) !!}');"></div>
                                </div>
                                <h3>{{$value['name']}}</h3>
                                <p>{{substr($value['premiered'], 0, 4)}}</p>
                            </a>
                        </div>
                        <?php $count++; ?>
                        @else
                         @break
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid popular-h" style="background-image: url('{{$page_content->section_fifth[1]->content}}');">
        <div class="popular-category">
            <a href="popular-books" class="pull-right"><button>VIEW ALL</button></a>
            <h2>{{$page_content->section_fifth[0]->content}}</h2>
            <div class="container">
                <div class="row">
                    @foreach ($books['results']['lists'][0]['books'] as $key => $value)
                    @if ($key < 4)
                    <div class="col-md-3">
                        <a href="#">
                            <div class="img-holder">
                                <div class="shadow-inset" style="background-image: url('{{$value['book_image']}}');"></div>
                            </div>
                            <h3>{{$value['title']}}</h3>
                            <p>{{substr($value['created_date'], 0, 4)}}</p>
                        </a>
                    </div>   
                    @else
                        @break    
                    @endif
                    @endforeach
                </div> 
            </div>
        </div>
    </div>
    <div class="container-fluid popular-h2" style="background-image: url('{{$page_content->section_sixth[1]->content}}');">
        <div class="popular-category">
            <a href="articles" class="pull-right"><button>VIEW ALL</button></a>
            <h2>{{$page_content->section_sixth[0]->content}}</h2>
            <div class="container">
                <div class="row">
                    @foreach($articles as $key => $value)
                        <div class="col-md-3">
                            <a href="articles/{{Crypt::encrypt($value['id'])}}">
                                <div class="img-holder">
                                    <div class="shadow-inset" style="background-image: url('{!!$value['image'] == '' ? $settings->avatar : 'https://'.substr($value['image'], 7) !!}');"></div>
                                </div>
                                <h3>{{$value['name']}}</h3>
                                <p>{{substr($value['created_at'], 0, 4)}}</p>
                            </a>
                        </div>
                    @endforeach
                </div> 
            </div>
        </div>
    </div>
</div>
@stop
