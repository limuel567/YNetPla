@extends('backend.default')
@section('title',ucwords($challenge->name).' Photo Contest  ~ Zuslo Admin')
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-12">
        <div class="bd bgc-white">
            <div class="peers fxw-nw@lg+ ai-s">
                <div class="peer bdL p-20 w-50p@lg+ w-100p@lg-">
                    <div class="layers">
                        <div class="layer w-100">
                            <div class="layers">
                                <div class="layer w-100">
                                    @if($challenge->status == 0)
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500 pull-right">Open</span>
                                    @elseif($challenge->status == 1)
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500 pull-right">Voting</span>
                                    @else
                                    <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500 pull-right">Closed</span>
                                    @endif
                                    <h2>{{ucwords($challenge->name)}} Photo Contest</h2> 
                                    <div class="creative-brief mT-10 mB-10">
                                        {!! $challenge->creative_brief !!}
                                    </div>
                                    {{-- <form id="creative-brief-form" class="d-none">
                                        <div class="form-group">
                                            <textarea class="form-control" data-svg-path="{{ asset('backend/icons.svg') }}" rows="4" name="creative_brief">{!!htmlentities($challenge->creative_brief)!!}</textarea>
                                        </div>
                                    </form> --}}
                                    {{-- @if($challenge->status == 1 || $challenge->status == 2)
                                    <p class="mT-10 fw-600"><i class="ti-medall"></i> &nbsp;{{$challenge->reward}}</p>
                                    <p class="fw-600"><i class="ti-image"></i> &nbsp;{{number_format($challenge->submission_count, 0)}} entries</p>
                                    @endif --}}
                                    @if($challenge->status == 0)
                                    <a href="{{URL('admin/challenges?s=open')}}">See All Challenges Open For Entry</a>
                                    @elseif($challenge->status == 1)
                                    <a href="{{URL('admin/challenges?s=voting')}}">See All Challenges Open For Voting</a>
                                    @else
                                    <a href="{{URL('admin/challenges?s=closed')}}">See All Closed Challenges</a>
                                    @endif
                                    {{-- <button class="btn btn-sm btn-light pull-right edit-challenge" data-toggle="button" aria-pressed="false" autocomplete="off"><i class="ti-pencil-alt"></i></button>
                                    <button class="btn btn-sm btn-success pull-right d-none save-changes">Save Changes</button> --}}
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="peer peer-greed w-50p@lg+ w-100@lg- p-20">
                    <div class="layers">
                        <div class="layer w-100">
                            {{-- @if($challenge->status == 0) --}}
                            @if($challenge->contest_type == 2)
                            <div class="pull-right">
                                <small class="fw-600">Sponsored by:</small><br>
                                @if($challenge->sponsor_logo != NULL)
                                <img height="100" src="{{$challenge->sponsor_logo}}" alt="">
                                @endif
                            </div>
                            @endif
                            <p class="mT-10 fw-600"><i class="ti-medall"></i> &nbsp;{{$challenge->reward}}</p>
                            <p class="fw-600"><i class="ti-image"></i> &nbsp;{{number_format($challenge->submission_count, 0)}} entries</p>
                            {{-- @endif --}}
                            <p class="mT-10 fw-600"><i class="ti-timer"></i>
                                @if($challenge->status == 0)
                                &nbsp;<span class="countdown-timer-start countdown-timer-component fw-600" data-voting-starts="{!! Carbon\Carbon::parse($challenge->opens_for_voting_at)->toRfc7231String() !!}">Time to Enter: <span id="voting-start"></span></span>
                                @elseif($challenge->status == 1)
                                &nbsp;<span class="countdown-timer-end countdown-timer-component fw-600" data-now="{!! Carbon\Carbon::now('America/New_York')->toRfc7231String() !!}" data-voting-ends="{!! Carbon\Carbon::parse($challenge->ends_at)->toRfc7231String() !!}">Voting Ends: <span id="voting-end"></span></span>
                                @else
                                &nbsp;<span>Ended {!! Carbon\Carbon::parse($challenge->ends_at)->format('d/m/Y') !!}</span></span>
                                @endif
                                @php
                                $votes = App\Models\Vote::where('challenge_id', $challenge->id)->count();
                                @endphp
                                @if($challenge->status == 1)
                                <span class="fw-600 pull-right"><i class="ti-check-box"></i> &nbsp;{{number_format($votes, 0)}} votes</span>
                                @endif
                            </p>
                            @if($challenge->status == 1 || $challenge->status == 2)
                                <h6>Top photos</h6>
                                <div class="top-photos">
                                    @foreach($top_entries as $value)
                                        @php
                                            $photo = App\Models\Photo::find($value->photo_id);
                                            $photo_votes = App\Models\Vote::where('photo_id', $value->photo_id)->where('challenge_id', $challenge->id)->get();
                                            $sort_entries = App\Models\Entry::where('challenge_id', $challenge->id)->orderBy('vote_count', 'desc')->get()->toArray();
                                            $rank = array_search($photo->id, array_column($sort_entries, 'photo_id'));
                                            $percent = 0;
                                            if(count($photo_votes)){
                                                $percent = (count($photo_votes) / $votes) * 100;
                                            }
                                        @endphp
                                        <div class="top-entry">
                                            <img src="{{$photo->standard_url}}" style="cursor: pointer;max-width: {{$rank+1 == 1 ? '120' : '80'}}px; margin: 2px" onclick="window.location='{{ URL('admin/photos/'.$photo->filename)}}'" alt="">
                                            @if($challenge->status == 1)
                                                <span class="pull-right c-grey-600 fsz-sm"><b>{{count($photo_votes)}} votes ~ #{{number_format($rank, 0)+1}} of {{number_format(count($entries), 0)}}</b></span>
                                            @else
                                                <span class="c-grey-600 fsz-sm"><b>Rank #{{number_format($rank, 0)+1}}</b></span>
                                                <span class="pull-right c-grey-600 fsz-sm">{{count($photo_votes)}} votes ~ #{{number_format($rank, 0)+1}} of {{number_format(count($entries), 0)}}</span>
                                            @endif
                                                <div class="progress mT-10">
                                                    <div class="progress-bar bgc-grey-500" role="progressbar" aria-valuenow="{{number_format($percent, 0)}}" aria-valuemin="0" aria-valuemax="100" style="width:{{number_format($percent, 0)}}%;"> <span class="sr-only">50% Complete</span></div>
                                                </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-12">
        <div class="bd bgc-white">
            <div class="peers fxw-nw@lg+ ai-s">
                <div class="peer bdL p-20 w-100p@lg+ w-100p@lg-">
                    <div class="layers">
                        @if(count($entries))
                        <div class="layer w-100 mB-10">
                            <h5>
                                Current Entries
                            </h5>
                        </div>
                        <div class="layer w-100">
                            <div class="stock-photos">
                                @foreach($entries as $value)
                                @php
                                $photo = App\Models\Photo::find($value->photo_id);
                                @endphp
                                <div class="entry">
                                    <img src="{{$photo->standard_url}}" style="cursor: pointer" onclick="window.location='{{ URL('admin/photos/'.$photo->filename)}}'" alt="">
                                    {{-- @if(($challenge->status == 1 || $challenge->status == 2) && $value->vote_count != NULL)
                                        <div class="rank" style="display: block;position: absolute;background: rgba(0,0,0,.3);bottom: 20px;color: #fff;font-size: 20px;left: 20px;padding: 4px 12px;">{{$value->rank + 1}}</div>
                                    @endif --}}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                            <div class="layer w-100">
                                <i>
                                    No entries yet.
                                </i>
                            </div>
                        @endif
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
    $.trumbowyg.svgPath = $('textarea').data('svg-path');
    $('textarea').trumbowyg();
    // Set the date we're counting down to
    var countDownDate = new Date($('.countdown-timer-end').data('voting-ends')).getTime();
    var countDownDate1 = new Date($('.countdown-timer-start').data('voting-starts')).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();
        
        // Find the distance between now an the count down date
        var distance = countDownDate - now;
        var distance1 = countDownDate1 - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        // Time calculations for days, hours, minutes and seconds
        var days1 = Math.floor(distance1 / (1000 * 60 * 60 * 24));
        var hours1 = Math.floor((distance1 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes1 = Math.floor((distance1 % (1000 * 60 * 60)) / (1000 * 60));
        var seconds1 = Math.floor((distance1 % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        if(days > 0){
            $("#voting-end").text(days + "d " + hours + "hr " + minutes + "m " + seconds + "s ");
        }else{
            if(hours > 0){
                $("#voting-end").text(hours + "hr " + minutes + "m " + seconds + "s ");
            }else{
                $("#voting-end").addClass('c-red-500');
                if(minutes > 0){
                    $("#voting-end").text(minutes + "m " + seconds + "s ");
                }else{
                    $("#voting-end").text(seconds + "s ");
                }
            }
        }

        if(days1 > 0){
            $("#voting-start").text(days1 + "d " + hours1 + "hr " + minutes1 + "m " + seconds1 + "s ");
        }else{
            if(hours1 > 0){
                $("#voting-start").text(hours1 + "hr " + minutes1 + "m " + seconds1 + "s ");
            }else{
                $("#voting-start").addClass('c-red-500');
                if(minutes1 > 0){
                    $("#voting-start").text(minutes1 + "m " + seconds1 + "s ");
                }else{
                    $("#voting-start").text(seconds1 + "s ");
                }
            }
        }
        
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            $("#voting-end").text("0s");
            $.ajax({
                'url'      : "{!! URL('challenges/"+slug+"/check') !!}",
                'dataType' : 'json',
                success    : function(data){
                    if(data.result == 'success'){
                        $('.countdown-timer-end').remove();
                        $('.vote-action').remove();
                        $('.timer-wrapper').append(data.html);
                    }
                }
            });
        }
        // If the count down is over, write some text 
        if (distance1 < 0) {
            clearInterval(x);
            $("#voting-start").text("0s");
            $.ajax({
                'url'      : "{!! URL('challenges/"+slug+"/check') !!}",
                'dataType' : 'json',
                success    : function(data){
                    if(data.result == 'success'){
                        $('.countdown-timer-start').remove();
                        $('.submit-action').remove();
                        $('.timer-wrapper').append(data.html);
                    }
                }
            });
        }
    }, 1000);
    // $('.edit-challenge').click(function(){
    //     $('#creative-brief-form').removeClass('d-none');
    //     $('.creative-brief').addClass('d-none');
    // });
</script>
@stop