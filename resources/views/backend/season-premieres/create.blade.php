@extends('backend.default')
@section('title',$label == 'Edit' ? "Edit Season Premiere ~ YNetPla Admin" : "Add Season Premiere ~ YNetPla Admin")
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <div class="bgc-white p-20 bd">
            <h4 class="c-grey-900">@if($label == 'Add') Add Season Premiere @else Edit Season Premiere @endif</h4>
            <div class="mT-30">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <form action="">
                            <label for="keywords">Search Shows:</label>
                        <input type="text" name="keywords" class="form-control" placeholder="" value="{{isset($keywords) ? $keywords : ''}}">
                            <div class="invalid-feedback" id="keywords"></div>
                        </form>
                    </div>
                    <div class="form-group col-md-6"></div>
            @if (count($search) != 0)
                @foreach ($search as $item)
                    @if(!isset($keywords))
                        @if ($label == 'Edit')
                        <?php $item = json_decode($item['encoded_json'], TRUE);?>
                        <div title="{{$item['name']}}" class="form-group col-md-3 pick" style="position:relative;">
                            <label class="pick-title">{{strlen($item['name']) > 20 ? str_limit($item['name'], 10) : $item['name']}}</label>
                            <img class="pick-img" src="{!!$item['image']['medium'] == '' ? $avatar->avatar : 'https://'.substr($item['image']['medium'],7) !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                            <label class="pick-year">{{substr($item['premiered'], 0,4)}}</label>
                            <div class="selected" style="z-index: 10;display:unset;height: 260px;position: absolute;top: 29px;left: 0;padding-top: 50%;margin: 0;text-align: center;right: 0;">
                                <h2 style="color: #d31c1c;text-shadow: -1px 2px 2px #000;transform: rotate(-45deg);font-size: 3vw;">SELECTED</h2>
                            </div>
                            <form id="form-selected">
                                <input type="hidden" id="selected" name="selected" value="{{Crypt::encrypt($item['id'])}}" class="form-control">
                                <input type="hidden" id="status" name="status" value="" class="form-control">
                            </form>    
                        @else
                        <?php $item = unserialize($item['serialize']); $check_selected = App\Models\SeasonPremieres::find($item['id']);?>
                        <div title="{{$item['name']}}" class="form-group col-md-3 pick" style="position:relative;">
                            <label class="pick-title">{{strlen($item['name']) > 20 ? str_limit($item['name'], 10) : $item['name']}}</label>
                            <img class="pick-img" src="{!!$item['image']['medium'] == '' ? $avatar->avatar : 'https://'.substr($item['image']['medium'],7) !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                            <label class="pick-year">{{substr($item['premiered'], 0,4)}}</label>
                            <div class="selected" style="z-index: 10;{{$check_selected ? 'display:unset;' : 'display:none;'}}height: 260px;position: absolute;top: 29px;left: 0;padding-top: 50%;margin: 0;text-align: center;right: 0;">
                                <h2 style="color: #d31c1c;text-shadow: -1px 2px 2px #000;transform: rotate(-45deg);font-size: 3vw;">SELECTED</h2>
                            </div>
                            <form id="form-selected">
                                <input type="hidden" id="selected" name="selected" value="{{Crypt::encrypt($item['id'])}}" class="form-control">
                                <input type="hidden" id="status" name="status" value="" class="form-control">
                            </form>
                        @endif
                    @else
                        @if ($label == 'Edit')
                        <?php $item = json_decode($item['encoded_json'], TRUE);?>
                        <div title="{{$item['name']}}" class="form-group col-md-3 pick" style="position:relative;">
                            <label class="pick-title">{{strlen($item['name']) > 20 ? str_limit($item['name'], 10) : $item['name']}}</label>
                            <img class="pick-img" src="{!!$item['image']['medium'] == '' ? $avatar->avatar : 'https://'.substr($item['image']['medium'],7) !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                            <label class="pick-year">{{substr($item['premiered'], 0,4)}}</label>
                            <div class="selected" style="z-index: 10;display:unset;height: 260px;position: absolute;top: 29px;left: 0;padding-top: 50%;margin: 0;text-align: center;right: 0;">
                                <h2 style="color: #d31c1c;text-shadow: -1px 2px 2px #000;transform: rotate(-45deg);font-size: 3vw;">SELECTED</h2>
                            </div>
                            <form id="form-selected">
                                <input type="hidden" id="selected" name="selected" value="{{Crypt::encrypt($item['id'])}}" class="form-control">
                                <input type="hidden" id="status" name="status" value="" class="form-control">
                            </form>    
                        @else
                        <?php $item = unserialize($item['serialize']); $check_selected = App\Models\SeasonPremieres::find($item['id']);?>
                        <div title="{{$item['name']}}" class="form-group col-md-3 pick" style="position:relative;">
                            <label class="pick-title">{{strlen($item['name']) > 20 ? str_limit($item['name'], 10) : $item['name']}}</label>
                            <img class="pick-img" src="{!!$item['image']['medium'] == '' ? $avatar->avatar : 'https://'.substr($item['image']['medium'],7) !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                            <label class="pick-year">{{substr($item['premiered'], 0,4)}}</label>
                            <div class="selected" style="z-index: 10;{{$check_selected ? 'display:unset;' : 'display:none;'}}height: 260px;position: absolute;top: 29px;left: 0;padding-top: 50%;margin: 0;text-align: center;right: 0;">
                                <h2 style="color: #d31c1c;text-shadow: -1px 2px 2px #000;transform: rotate(-45deg);font-size: 3vw;">SELECTED</h2>
                            </div>
                            <form id="form-selected">
                                <input type="hidden" id="selected" name="selected" value="{{Crypt::encrypt($item['id'])}}" class="form-control">
                                <input type="hidden" id="status" name="status" value="" class="form-control">
                            </form>
                        @endif    
                    @endif
                        </div>    
                @endforeach        
            @else
            <div class="col-md12"><p>Show not found!</p></div>
            @endif
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
            $(e.target).next().next().next().find('#status').val('save');
            setTimeout(function(){
                var formData = new FormData($(e.target).siblings('#form-selected')[0]);
                $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url'      : "{!! URL('admin/season-premiere/add') !!}",
                    'method'   : 'post',
                    'dataType' : 'json',
                    'data'     : formData,
                    'processData': false,
                    'contentType': false,
                    success    : function(data){
                        if(data.result == 'success'){
                            $(e.target).next().next().css('display', 'unset');
                            noty({
                                theme: 'app-noty',
                                text: 'Success! The show successfully added.',
                                type: 'success',
                                timeout: 3000,
                                layout: 'bottomRight',
                                closeWith: ['button', 'click'],
                                animation: {
                                    open: 'noty-animation fadeIn',
                                    close: 'noty-animation fadeOut'
                                }
                            });
                        }else if(data.result == 'alreadyPremiere'){
                            noty({
                                theme: 'app-noty',
                                text: 'Error! The show you choose already premiered.',
                                type: 'error',
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
        });
        $(".selected").click(function(e){
            if($(e.target).is('div')){
                $(e.target).next().find('#status').val('delete');
                var formData = new FormData($(e.target).siblings('#form-selected')[0]);
            }else{
                $(e.target).parent().next().find('#status').val('delete');
                var formData = new FormData($(e.target).parent().siblings('#form-selected')[0]);
            }
            setTimeout(function(){
                $.ajax({
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'url'      : "{!! URL('admin/season-premiere/add') !!}",
                    'method'   : 'post',
                    'dataType' : 'json',
                    'data'     : formData,
                    'processData': false,
                    'contentType': false,
                    success    : function(data){
                        if(data.result == 'success'){
                            if($(e.target).is('div')){
                                $(e.target).css('display', 'none');
                            }else{
                                $(e.target).parent().css('display', 'none');
                            }
                            noty({
                                theme: 'app-noty',
                                text: 'Success! The show successfully deleted.',
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
        });
    });
</script>
@stop