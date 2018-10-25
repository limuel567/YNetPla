@extends('frontend.layout')
@section('title','YNetPla')
@section('content')
<?php $cnt = 0; ?>
<div class="container-fluid books-banner search-books-section-edit" style="background-image: url('../frontend/img/books-banner.png');">
    <form action="{{URL(Request::segment(1))}}" method="get" class="form">
        <input name="keywords" type="text" value="{!! $keywords != '' ? $keywords : '' !!}" placeholder="Search Books">
        <button><i class="fa fa-search"></i></button>
    </form>
</div>
<div class="container-fluid search-books-section" style="background-image: url('../frontend/img/top-book-section.png');">
    <div class="container">
        <div class="row" id="content-main">
            <div id="content-inner" class="col-md-12">
                <div id="left-part" class="col-md-5">
                    <div class="tv-series-bg">
                        <div id="imgholdertv" class="img-holder-tv">
                            <div id="shadow" class="shadow-inset" style="background-image: url('{{$selected['path'] == '' ? $settings->avatar : $selected['path']}}');"></div>
                        </div>
                    </div>
                </div>
                <div id="center-part" class="col-md-7">
                    <div class="movie-title">
                        <h2 style="font-size:30px;">{{$selected['volumeInfo']['title']}}</h2>
                        <div id="movieinfoholder">
                            <h3 style="margin-top:0;">Author: {{rtrim(implode(", ",$selected['volumeInfo']['authors']), ', ')}}</h3>
                            <div class="movie-des">
                                <p style="margin-top: 24px;font-size: 14.68px;line-height: 30px;">{!!$selected['volumeInfo']['description']!!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($other_books['totalItems'] != 0)
    @if (count($other_books['items']) >= 1)
    <section class="sec2-series">
        <div class="sec2-series-bg" style="background-image: url('../frontend/img/tv-series.jpg');">
            <div class="container">
            <div class="row">
                    <h2>Other Books of {{$selected['volumeInfo']['authors'][0]}}</h2>
                        <div class="sec2-series-content1">
                            <div class="slider-area">
                                <div class="owl-carousel owl-theme first-slider">
                                    @foreach ($other_books['items'] as $key => $item)
                                        @if ($item['volumeInfo']['title'] != $selected['volumeInfo']['title'])
                                            <div class="item">
                                                <div class="center-position">
                                                    <?php
                                                        $volumeData = App\Models\Configuration::getFile($item['selfLink'].'?key=AIzaSyCTRZ-B6RTHUNCzDdI8kLdiHT9Yckw-nIU');
                                                    ?>
                                                    @if (isset($volumeData['volumeInfo']['imageLinks']) && $volumeData['volumeInfo']['imageLinks'] != '')
                                                        <?php 
                                                            $idAndPath = ['id' => $volumeData['selfLink'], 'path' => end($volumeData['volumeInfo']['imageLinks'])];
                                                            $path = $volumeData['volumeInfo']['imageLinks']['thumbnail'];
                                                        ?>     
                                                    @else
                                                        <?php 
                                                            $idAndPath = ['id' => $volumeData['selfLink'], 'path' => $settings->avatar];
                                                            $path = $settings->avatar;
                                                        ?>
                                                    @endif
                                                    <a href="{{Crypt::encrypt(serialize($idAndPath))}}">
                                                        <div class="box-shadow-cast">
                                                            <img src="{{$path}}">
                                                        </div>
                                                        <div style="width: 197px;">
                                                            <h2>{{$item['volumeInfo']['title']}}</h2>
                                                            <h3><span>in</span> {{$item['volumeInfo']['publishedDate']}}</h3>    
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>    
                                        @endif
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
@if ($associated['totalItems'] != 0)
    @if (count($associated['items']) >= 1)
    <section class="sec2-series">
        <div class="sec2-series-bg" style="background-image: url('../frontend/img/top-book-section.png');">
            <div class="container">
            <div class="row">
                    <h2 style="color: #3d3d3d;">Associated Books</h2>
                        <div class="sec2-series-content1">
                            <div class="slider-area">
                                <div class="owl-carousel owl-theme second-slider">
                                    @foreach ($associated['items'] as $key => $item)
                                        @if ($item['volumeInfo']['title'] != $selected['volumeInfo']['title'])
                                            <div class="item">
                                                <div class="center-position">
                                                    <?php
                                                        $volumeData = App\Models\Configuration::getFile($item['selfLink'].'?key=AIzaSyCTRZ-B6RTHUNCzDdI8kLdiHT9Yckw-nIU');
                                                    ?>
                                                    @if (isset($volumeData['volumeInfo']['imageLinks']) && $volumeData['volumeInfo']['imageLinks'] != '')
                                                        <?php 
                                                            $idAndPath = ['id' => $volumeData['selfLink'], 'path' => end($volumeData['volumeInfo']['imageLinks'])];
                                                            $path = $volumeData['volumeInfo']['imageLinks']['thumbnail'];
                                                        ?>     
                                                    @else
                                                        <?php 
                                                            $idAndPath = ['id' => $volumeData['selfLink'], 'path' => $settings->avatar];
                                                            $path = $settings->avatar;
                                                        ?>
                                                    @endif
                                                    <a href="{{Crypt::encrypt(serialize($idAndPath))}}">
                                                        <div class="box-shadow-cast">
                                                            <img src="{{$path}}">
                                                        </div>
                                                        <div style="width: 197px;">
                                                            <h2 style="color: #000000;">{{$item['volumeInfo']['title']}}</h2>
                                                            <h3 style="color: #000000;"><span style="color: #03364e;">in</span> {{$item['volumeInfo']['publishedDate']}}</h3>    
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>    
                                        @endif
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
@stop
@section('js')
<script type="text/javascript">
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
