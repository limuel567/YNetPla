@extends('backend.default')
@section('title',$label == 'Edit' ? "Edit Editor's Choice ~ YNetPla Admin" : "Create Editor's Choice ~ YNetPla Admin")
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <form id="top-picks-form" method="POST">
        @if ($top_picks->name == 'Movie')
        <input type="hidden" name="id" class="form-control" value="@if($label == 'Edit'){{Crypt::encrypt($top_picks->id)}}@endif">
        <div id="top-pick-holder" style="display:block;padding: 10px;max-width: 819.33px;z-index: 99999999999999;min-height: 260px;position: fixed;top: 65px;background-color: #f9fafb;">
            <div>
                <div class="row">
                    @foreach ($selected as $key => $item)
                    @if ($item !== null)
                    <?php $item = unserialize($item->data);?>
                    <div class="col-md-3">
                        <label class="top-pick-title">{{strlen($item[1]) > 20 ? str_limit($item[1], 20) : $item[1]}}</label>
                        <img src="{{'//image.tmdb.org/t/p/original'.$item[2]}}" alt="" class="top-pick-holder" style="border: 1px solid #000000; width:100%; max-height:200px;">
                        <label class="top-pick-year">{{substr($item[3], 0,4)}}</label>
                        <input type="hidden" class="form-control" name="{{'holder'.($key+1)}}" value="{{Crypt::encrypt($item[0])}}">
                    </div>
                    @else
                    <div class="col-md-3">
                        <label class="top-pick-title">Title</label>
                        <img src="{{$avatar->avatar}}" alt="" class="top-pick-holder" style="border: 1px solid #000000; width:100%; max-height:200px;">
                        <label class="top-pick-year">Year</label>
                        <input type="hidden" class="form-control" name="{{'holder'.($key+1)}}">
                    </div>
                    @endif
                    @endforeach
                </div>
        @else
        <input type="hidden" name="id" class="form-control" value="@if($label == 'Edit'){{Crypt::encrypt($top_picks->id)}}@endif">
        <div id="top-pick-holder" style="display:none;padding: 20px;max-width: 819.33px;z-index: 99999999999999;height: 260px;position: fixed;top: 65px;background-color: #f9fafb;">
            <div style="overflow-x: scroll;">
                <div style="width: 1384px;">
                    <div class="row" style="padding:0 20px;">
                        @foreach ($selected as $key => $item)
                        @if ($item !== null)
                        <?php $item = unserialize($item->data);?>
                        <div style="width:171.66px;padding:0 5px;">
                            <label class="top-pick-title">{{$item[1]}}</label>
                            <img src="{{$item[2]}}" alt="" class="top-pick-holder" style="border: 1px solid #000000; width:100%; max-height:182px;">
                            <label class="top-pick-year">{{substr($item[3], 0,4)}}</label>
                            <input type="hidden" class="form-control" name="{{'holder'.($key+1)}}" value="{{Crypt::encrypt($item[0])}}">
                        </div>    
                        @else
                        <div style="width:171.66px;padding:0 5px;">
                            <label class="top-pick-title">Title</label>
                            <img src="{{$avatar->avatar}}" alt="" class="top-pick-holder" style="border: 1px solid #000000; width:100%; max-height:182px;">
                            <label class="top-pick-year">Year</label>
                            <input type="hidden" class="form-control" name="{{'holder'.($key+1)}}">
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
        @endif
            </div>
        </div>
        </form>
        <div class="bgc-white p-20 bd" style="margin-top: 260px;">
            <h4 class="c-grey-900">@if($label == 'Add') Create Editor's Choice @else Edit {{ucwords($top_picks->name)}} Editor's Choice @endif</h4>
            <div class="mT-30">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Editor's Choice Name</label>
                        <input readonly type="text" name="name" class="form-control" value="@if($label == 'Edit') {{$top_picks->name}}@endif">
                        <div class="invalid-feedback" id="name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <form action="">
                            <label for="keywords">Search {!!$top_picks->name!!}:</label>
                        <input type="text" name="keywords" class="form-control" placeholder="" value="{{isset($keywords) ? $keywords : ''}}">
                            <div class="invalid-feedback" id="keywords"></div>
                        </form>
                    </div>
                    @foreach ($search as $item)
                        @if($top_picks->name == 'Movie')
                    <div title="{{$item->getTitle()}}" class="form-group col-md-3 pick">
                        <label class="pick-title">{{strlen($item->getTitle()) > 20 ? str_limit($item->getTitle(), 20) : $item->getTitle()}}</label>
                        <img class="pick-img" src="{!!$item->getPosterImage() == '' ? $avatar->avatar : '//image.tmdb.org/t/p/original'.$item->getPosterImage() !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                        <label class="pick-year">{{substr(get_object_vars($item->getReleaseDate())['date'], 0,4)}}</label>
                        <input type="hidden" id="top-picked" value="{{Crypt::encrypt($item->getId())}}" class="form-control">
                        @else
                            @if(!isset($keywords))
                        <?php $item = unserialize($item['serialize']); ?>
                    <div title="{{$item['name']}}" class="form-group col-md-3 pick">
                        <label class="pick-title">{{strlen($item['name']) > 20 ? str_limit($item['name'], 20) : $item['name']}}</label>
                        <img class="pick-img" src="{!!$item['image']['medium'] == '' ? $avatar->avatar : $item['image']['medium'] !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                        <label class="pick-year">{{substr($item['premiered'], 0,4)}}</label>
                        <input type="hidden" id="top-picked" value="{{Crypt::encrypt($item['id'])}}" class="form-control">
                            @else
                    <div title="{{$item->name}}" class="form-group col-md-3 pick">
                        <label class="pick-title">{{strlen($item->name) > 20 ? str_limit($item->name, 20) : $item->name}}</label>
                        <img class="pick-img" src="{!!$item->images['medium'] == '' ? $avatar->avatar : $item->images['medium'] !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                        <label class="pick-year">{{substr($item->premiered, 0,4)}}</label>
                        <input type="hidden" id="top-picked" value="{{Crypt::encrypt($item->id)}}" class="form-control">
                            @endif
                        @endif
                    </div>    
                    @endforeach
                    <div class="row" style="width:100%;margin:0 auto;justify-content:center;">
                        <div>
                            {!! $search->appends(Input::except('page'))->render() !!}
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" integrity="sha256-tW5LzEC7QjhG0CiAvxlseMTs2qJS7u3DRPauDjFJ3zo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<script>
    $(document).ready(function(){
        $(".pick-img").click(function(e){
            var background = $(e.target).attr('src');
            var title = $(e.target).prev().text();
            var year = $(e.target).next().text();
            var picked = $(e.target).next().next().val();
            var exist = true;
            $( ".top-pick-holder" ).each(function( index ) {
                if($(this).attr('src') == background){
                    exist = true;
                    return false;
                }else{
                    exist = false;
                }
            });
            if(exist == false){
                $( ".top-pick-holder" ).each(function( index ) {
                    if($(this).attr('src') == '{{$avatar->avatar}}'){
                        $(this).attr('src', background);
                        $(this).prev().text(title);
                        $(this).next().text(year);
                        $(this).next().next().val(picked);
                        return false;
                    }
                });
                //--AJAX--//
                setTimeout(function(){
                    var formData = new FormData($('#top-picks-form')[0]);
                    $.ajax({
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'url'      : "{!! URL('admin/editor-choice/create/"+picked+"') !!}",
                        'method'   : 'post',
                        'dataType' : 'json',
                        'data'     : formData,
                        'processData': false,
                        'contentType': false,
                        success    : function(data){
                            if(data.result == 'success'){
                                noty({
                                    theme: 'app-noty',
                                    text: "Success! The Editor's Choice successfully added.",
                                    type: 'success',
                                    timeout: 3000,
                                    layout: 'bottomRight',
                                    closeWith: ['button', 'click'],
                                    animation: {
                                        open: 'noty-animation fadeIn',
                                        close: 'noty-animation fadeOut'
                                    }
                                });
                            }else{
                                noty({
                                    theme: 'app-noty',
                                    text: "Success! The Editor's Choice successfully deleted.",
                                    type: 'success',
                                    timeout: 3000,
                                    layout: 'bottomRight',
                                    closeWith: ['button', 'click'],
                                    animation: {
                                        open: 'noty-animation fadeIn',
                                        close: 'noty-animation fadeOut'
                                    }
                                });
                            }
                        },
                        beforeSend: function(){
                            $("#loader").removeClass();
                        },
                        complete: function(){
                            $("#loader").addClass('fadeOut');
                        }
                    });
                    return false;
                }, 500);
                //--END AJAX--//
            }
        });
        $('.top-pick-holder').click(function(e){
            var picked = $(e.target).next().next().val();
            //--AJAX--//
            setTimeout(function(){
                var formData = new FormData($('#top-picks-form')[0]);
                $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url'      : "{!! URL('admin/editor-choice/create/"+picked+"') !!}",
                    'method'   : 'post',
                    'dataType' : 'json',
                    'data'     : formData,
                    'processData': false,
                    'contentType': false,
                    success    : function(data){
                        if(data.result == 'success'){
                            noty({
                                theme: 'app-noty',
                                text: "Success! The Editor's Choice successfully added.",
                                type: 'success',
                                timeout: 3000,
                                layout: 'bottomRight',
                                closeWith: ['button', 'click'],
                                animation: {
                                    open: 'noty-animation fadeIn',
                                    close: 'noty-animation fadeOut'
                                }
                            });
                        }else{
                            noty({
                                theme: 'app-noty',
                                text: "Success! The Editor's Choice successfully deleted.",
                                type: 'success',
                                timeout: 3000,
                                layout: 'bottomRight',
                                closeWith: ['button', 'click'],
                                animation: {
                                    open: 'noty-animation fadeIn',
                                    close: 'noty-animation fadeOut'
                                }
                            });
                        }
                    },
                    beforeSend: function(){
                        $("#loader").removeClass();
                    },
                    complete: function(){
                        $("#loader").addClass('fadeOut');
                    }
                });
                return false;
            }, 500);
            //--END AJAX--//
            $(e.target).attr('src', '{{$avatar->avatar}}');
            $(e.target).prev().text('Title');
            $(e.target).next().text('Year');
            $(e.target).next().next().val('');
        });
    });
</script>
@stop