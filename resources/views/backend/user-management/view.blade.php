@extends('backend.default')
@section('title',ucwords($user->full_name).' Profile ~ Zuslo Admin')
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-12">
        <div class="bd bgc-white">
            <div class="peers fxw-nw@lg+ ai-s">
            <div class="peer bdL p-20 w-30p@lg+ w-100p@lg-">
                <div class="layers">
                    <div class="layer w-100">
                        <div class="layers">
                            <div class="layer w-100 text-center">
                                <img src="{{$user->profile_photo}}" width="120" height="120" style="object-fit: cover" class="img-responsive rounded-circle" alt="">
                            </div>  
                            <div class="layer w-100 text-center mT-20 bdB">
                                <h5>{{ucwords($user->full_name)}}</h5>
                                <small><a href="{{URL($user->username.'/photos')}}" target="_blank">{{'@'.strtolower($user->username)}}</a></small>
                                <p>{{$user->bio}}</p>
                            </div>  
                            <div class="layer w-100 mT-10 bdB">
                                <p>{{$user->email}}</p>
                                <p>@if($user->country_name != NULL) {{ucwords($user->country_name)}} ({{strtoupper($user->country_code)}})@endif</p>
                                <p>{{count($photos)}} Stock Photos</p>
                                <p>{{count($followers)}} Followers | {{count($following)}} Following</p>
                                <p><a href="https://{!! $user->web_link !!}" target="_blank">{!! $user->web_link !!}</a></p>
                                <p>Member since {{Carbon\Carbon::parse($user->created_at)->format('M d, Y')}}</p>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20">
                <div class="layers">
                    <div class="layer w-100 mB-10">
                        <h6>{{ucwords($user->full_name)}} Stock Photos</h6>
                    </div>
                    <div class="layer w-100">
                        <div class="stock-photos">
                            @foreach($photos as $photo)
                            <img src="{{$photo->standard_url}}" style="cursor: pointer" onclick="window.location='{{ URL('admin/photos/'.$photo->filename)}}'" alt="">
                                {{-- <a class="stock-photo-item" style="background: url({{$photo->standard_url}});background-size: cover;" onclick="window.location='{{ URL('admin/photos/'.$photo->filename)}}'"></a> --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $('.stock-photos').gallerify({
        margin:5,
        mode:'default'
    });
</script>
@stop