@extends('backend.default')
@section('title', 'Edit Trailer ~ YNetPla Admin')
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <div class="bgc-white p-20 bd">
            <h4 class="c-grey-900">Edit Trailer</h4>
            <div class="mT-30">
                <form id="save-trailer" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">TV Series Title</label>
                            <input type="text" class="form-control" readonly value="{{$movie->getTitle()}}">
                        </div>
                        <div class="videolink form-group col-md-6">
                            <label for="youtube_link">YouTube or Vimeo Link</label>
                            @if ($movie_tmdb['trailer'] == '' && $trailer != '')
                            <input type="text" name="video_link" value="{{'https://www.youtube.com/watch?v='.$trailer}}" class="form-control preview_video">
                            @else
                            <input type="text" name="video_link" value="{{$movie_tmdb['trailer'] != '' ? ($movie_tmdb['video_host'] == 0 ? 'https://www.youtube.com/watch?v='.$movie_tmdb['trailer'] : 'https://vimeo.com/'.$movie_tmdb['trailer']) : ''}}" class="form-control preview_video">
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label for="youtube_link">Video Preview</label>
                            @if ($movie_tmdb['trailer'] == '' && $trailer != '')
                            <iframe id="video_here" src="{{'https://www.youtube.com/embed/'.$trailer.'?showinfo=0'}}" frameborder="0" allow="autoplay; encrypted-media" webkitallowfullscreen mozallowfullscreen allowfullscreen data-ready="true" style="width: 100%; height: 500px;"></iframe>    
                            @else
                            <iframe id="video_here" src="{{$movie_tmdb['trailer'] != '' ? ($movie_tmdb['video_host'] == 0 ? 'https://www.youtube.com/embed/'.$movie_tmdb['trailer'].'?showinfo=0' : 'https://player.vimeo.com/video/'.$movie_tmdb['trailer'].'?title=0&byline=0&portrait=0&transparent=0') : 'https://www.youtube.com/embed/bkifvuuIrXs?showinfo=0'}}" frameborder="0" allow="autoplay; encrypted-media" webkitallowfullscreen mozallowfullscreen allowfullscreen data-ready="true" style="width: 100%; height: 500px;"></iframe>    
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="id" class="form-control" value="{{Crypt::encrypt($movie_tmdb['id'])}}">
                    <input type="hidden" name="video_host" class="video-host form-control" value="{{$movie_tmdb['video_host']}}">
                    <button type="button" class="btn btn-primary submit-trailer">Submit Trailer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" integrity="sha256-tW5LzEC7QjhG0CiAvxlseMTs2qJS7u3DRPauDjFJ3zo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<script>
    $('.submit-trailer').click(function(){
        var formData = new FormData($('#save-trailer')[0]);
        console.log(formData);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/movies-trailer/edit') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                if(data.result == 'success'){
                    noty({
                        theme: 'app-noty',
                        text: 'Success!',
                        type: 'success',
                        timeout: 3000,
                        layout: 'bottomRight',
                        closeWith: ['button', 'click'],
                        animation: {
                            open: 'noty-animation fadeIn',
                            close: 'noty-animation fadeOut'
                        }
                    });
                    window.location.reload();
                }else if(data.result == 'youtube'){
                    noty({
                        theme: 'app-noty',
                        text: 'YouTube video does not exist, Please upload a valid video.',
                        type: 'error',
                        timeout: 3000,
                        layout: 'bottomRight',
                        closeWith: ['button', 'click'],
                        animation: {
                            open: 'noty-animation fadeIn',
                            close: 'noty-animation fadeOut'
                        }
                    });
                }else if(data.result == 'vimeo'){
                    noty({
                        theme: 'app-noty',
                        text: 'Vimeo video does not exist, Please upload a valid video.',
                        type: 'error',
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
                        text: 'Please check your inputs and try again..',
                        type: 'error',
                        timeout: 3000,
                        layout: 'bottomRight',
                        closeWith: ['button', 'click'],
                        animation: {
                            open: 'noty-animation fadeIn',
                            close: 'noty-animation fadeOut'
                        }
                    });
                    $('html, body').animate({
                        scrollTop: $(".bd").offset().top
                    }, 500);
                    $('input[name=video_link]').focus();
                }
            },
            beforeSend: function(){
                $('.submit-trailer').attr('disabled', true);
                $('.submit-trailer').text('Saving..');
            },
            complete: function(){
                $('.submit-trailer').attr('disabled', false);
                $('.submit-trailer').text('Submit Trailer');
            }
        });
        return false;
    });

    $(".preview_video").change(function() {
        var source = $('#video_here');
        var check_from = $(this).val().split(".com");
        if(check_from[0] == 'https://www.youtube'){
            var lastword = $(this).val().split("v=").pop();
            source[0].src = 'https://www.youtube.com/embed/'+lastword+'?showinfo=0';
            $('.video-host').val(0);
        }else if(check_from[0] == 'https://vimeo'){
            var lastword = $(this).val().split(".com/").pop();
            source[0].src = 'https://player.vimeo.com/video/'+lastword+'?title=0&byline=0&portrait=0&transparent=0';
            $('.video-host').val(1);
        }
    });
</script>
@stop