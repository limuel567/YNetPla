@extends('backend.default')
@section('title',$label == 'Edit' ? 'Edit Article ~ YNetPla Admin' : 'Create Article ~ YNetPla Admin')
@section('css')
<!-- Include external CSS. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

<!-- Include Editor style. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<style>
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
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <div class="bgc-white p-20 bd">
            <h4 class="c-grey-900">@if($label == 'Add') Create Article @else Edit {{ucwords($article->name)}} Article @endif</h4>
            <div class="mT-30">
                <form id="create-article">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group col-md-11">
                                <label for="name">Title*</label>
                                <input type="text" name="name" class="form-control" placeholder="Title Here" value="@if($label == 'Edit') {{$article->name}}@endif">
                                <div class="invalid-feedback" id="name"></div>
                            </div>
                            <div class="form-group col-md-11">
                                <label for="name">Author*</label>
                                <input type="text" name="author" class="form-control" placeholder="Author Name Here" value="@if($label == 'Edit') {{$article->author}}@endif">
                                <div class="invalid-feedback" id="author"></div>
                            </div>
                            <div class="form-group col-md-11" >
                                <label for="signature">Signature(Optional)</label>
                                <input type="file" name="signature" class="form-control" value="@if($label == 'Edit') {{$article->signature}}@endif">
                                <div class="invalid-feedback" id="signature"></div>
                            </div>
                            <div class="form-group col-md-11" >
                                <label for="show_author">Show Author?*</label>
                                <select class="form-control "name="show_author">
                                    <option disabled {{$label == 'Add' ? 'selected' : ''}}>Choose Here</option>
                                    <option {{$label == 'Edit' && $article->show_author == 0 ? 'selected' : ''}} value="0">YES</option>
                                    <option {{$label == 'Edit' && $article->show_author == 1 ? 'selected' : ''}} value="1">NO</option>
                                </select>
                                <div class="invalid-feedback" id="show_author"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image-upload">Article Image*</label>
                            <div class="form-control" name="image" style="padding:0!important;">
                            <div id="image-preview">
                                    <label id="image-label">Choose Image</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>
                            </div>      
                            <div class="invalid-feedback" id="image"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description*</label>
                            <div class="invalid-feedback" id="description"></div>
                            <div id="my_scrollable_container" style="width:100%;height:500px;overflow-y:scroll;">
                                <textarea id="froala-wysiwyg" class="form-control" name="description" rows="10">{{$label == 'Edit' ? unserialize($article->description) : ''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" class="form-control" value="@if($label == 'Edit'){{Crypt::encrypt($article->id)}}@endif">
                    <button type="button" class="btn btn-primary submit-article">Submit Article</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" integrity="sha256-tW5LzEC7QjhG0CiAvxlseMTs2qJS7u3DRPauDjFJ3zo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<script type="text/javascript" src="{!!asset('backend/js/jquery.uploadPreview.js')!!}"></script>
<!-- Include external JS libs. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/js/froala_editor.pkgd.min.js"></script>

<!-- Initialize the editor. -->
<script type= text/javascript>
    // var original_helpers = $.FE.MODULES.helpers; 
    // $.FE.MODULES.helpers = function (editor) { 
    // var helpers = original_helpers(editor); 

    // var isURL = helpers.isURL();  

    // // This is the original sanitizer.
    // helpers.sanitizeURL = function (url) { 
    //     if (/^(https?:|ftps?:|)\/\//i.test(url)) {
    //         if (!isURL(url) && !isURL('http:' + url)) {
    //         return '';
    //         }
    //     }
    //     else {
    //         url = encodeURIComponent(url)
    //                 .replace(/%23/g, '#')
    //                 .replace(/%2F/g, '/')
    //                 .replace(/%25/g, '%')
    //                 .replace(/mailto%3A/gi, 'mailto:')
    //                 .replace(/file%3A/gi, 'file:')
    //                 .replace(/sms%3A/gi, 'sms:')
    //                 .replace(/tel%3A/gi, 'tel:')
    //                 .replace(/notes%3A/gi, 'notes:')
    //                 .replace(/data%3Aimage/gi, 'data:image')
    //                 .replace(/blob%3A/gi, 'blob:')
    //                 .replace(/webkit-fake-url%3A/gi, 'webkit-fake-url:')
    //                 .replace(/%3F/g, '?')
    //                 .replace(/%3D/g, '=')
    //                 .replace(/%26/g, '&')
    //                 .replace(/&amp;/g, '&')
    //                 .replace(/%2C/g, ',')
    //                 .replace(/%3B/g, ';')
    //                 .replace(/%2B/g, '+')
    //                 .replace(/%40/g, '@')
    //                 .replace(/%5B/g, '[')
    //                 .replace(/%5D/g, ']')
    //                 .replace(/%7B/g, '{')
    //                 .replace(/%7D/g, '}');
    //     }

    //     return url;
    // }; 

    // return helpers;
    // } 
    $( window ).on( "load", function() {
        $('#froala-wysiwyg').froalaEditor({
        toolbarSticky: false
        })

        $.uploadPreview({
            input_field: "#image-upload",   // Default: .image-upload
            preview_box: "#image-preview",  // Default: .image-preview
            label_field: "#image-label",    // Default: .image-label
            label_default: "Choose File",   // Default: Choose File
            label_selected: "Change File",  // Default: Change File
            no_label: false                 // Default: false
        });
    });
    $('.submit-article').click(function(){
        var formData = new FormData($('#create-article')[0]);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/article-management/create') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                $(".invalid-feedback").empty();
                $("input").removeClass('is-invalid');
                $("select").removeClass('is-invalid');
                $("textarea").removeClass('is-invalid');
                $("div").removeClass('is-invallid');
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
                    $.each(data.errors,function(key,value){
                        if(value != ""){
                            $("#"+key).show();
                            $("#"+key).text(value);
                            $("input[name="+key+"]").addClass("is-invalid");
                            $("select[name="+key+"]").addClass("is-invalid");
                            $("textarea[name="+key+"]").addClass("is-invalid");
                            $("div[name="+key+"]").addClass("is-invalid");
                        }
                    });
                }
            },
            beforeSend: function(){
                $('.submit-article').attr('disabled', true);
                $('.submit-article').text('Creating..');
            },
            complete: function(){
                $('.submit-article').attr('disabled', false);
                $('.submit-article').text('Submit Article');
                $(".submit-article").focus();
            }
        });
        return false;
    });
</script>
@stop