@extends('frontend.layout')
@section('title','YNetPla')
@section('css')
    <style type="text/css">
        span.fr-emoticon {
            font-weight: 400;
            font-family: "Apple Color Emoji","Segoe UI Emoji",NotoColorEmoji,"Segoe UI Symbol","Android Emoji",EmojiSymbols;
            display: inline;
            line-height: 0
        }

        span.fr-emoticon.fr-emoticon-img {
            background-repeat: no-repeat!important;
            font-size: inherit;
            height: 1em;
            width: 1em;
            min-height: 20px;
            min-width: 20px;
            display: inline-block;
            margin: -.1em .1em .1em;
            line-height: 1;
            vertical-align: middle
        }
    </style>
@stop
@section('content')
<?php $cnt = 0; ?>
<div class="container-fluid books-banner search-books-section-edit" style="background-image: url('../frontend/img/books-banner.png');">
    <form action="{{URL(Request::segment(1))}}" method="get" class="form">
        <input name="keywords" type="text" value="{!! $keywords != '' ? $keywords : '' !!}" placeholder="Search Articles">
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
                            <div id="shadow" class="shadow-inset" style="background-image: url('{{$selected['image'] == '' ? $settings->avatar : 'https://'.substr($selected['image'],7) }}');"></div>
                        </div>
                    </div>
                </div>
                <div id="center-part" class="col-md-7">
                    <div class="movie-title">
                        <h2 style="font-size:30px;">{{$selected['name']}}</h2>
                        <div id="movieinfoholder">
                            @if ($selected['show_author'] == 0)
                            <h3 style="margin-top:0;">Author: {{$selected['author']}}</h3>
                            @endif
                            <div class="movie-des" style="height: 70vh;width: 100%;overflow: scroll;">
                                <p style="margin-top: 24px;font-size: 20.68px;line-height: 30px;">{!!unserialize($selected['description'])!!}</p>
                            </div>
                        </div>
                        @if ($selected['show_author'] == 0)
                        <div style="background-image: url('{{'https://'.substr($selected->signature,7)}}'); height:150px;width:300px;background-position:center center;background-size:100% 100%;backgroung-repeat:no-repeat;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (count($articles) > 1)
<section class="sec2-series">
    <div class="sec2-series-bg" style="background-image: url('../frontend/img/tv-series.jpg');">
        <div class="container">
        <div class="row">
                <h2>Other Articles</h2>
                    <div class="sec2-series-content1">
                        <div class="slider-area">
                            <div class="owl-carousel owl-theme">
                                @foreach ($articles as $item)
                                    @if ($item['id'] != $selected['id'])
                                        <div class="item">
                                            <div class="center-position">
                                                <a href="{{Crypt::encrypt($item['id'])}}">
                                                    <div class="box-shadow-cast">
                                                        <img src="{{$item['image'] == '' ? $settings->avatar : $item['image']}}">
                                                    </div>
                                                    <div style="width: 197px;">
                                                        <h2>{{$item['name']}}</h2>
                                                        @if ($item['show_author'] == 0)
                                                        <h3><span>by</span> {{$item['author']}}</h3>    
                                                        @endif
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
