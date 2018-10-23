@extends('backend.default')
@section('title','Settings ~ YNetPla Admin')
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-10 offset-md-1">
        <div class="bgc-white p-20 bd">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="defaults-tab" data-toggle="tab" href="#defaults" role="tab" aria-controls="defaults" aria-selected="false">Default Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="social-links-tab" data-toggle="tab" href="#social-links" role="tab" aria-controls="social-links" aria-selected="false">Social Links</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="api-keys-tab" data-toggle="tab" href="#api-keys" role="tab" aria-controls="api-keys" aria-selected="false">API Keys</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="p-20">
                        <h5>General Settings</h5>
                        <form id="general-form">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="image">Website Logo</label>
                                    <div id="image-preview" style="border-radius: 50%;width: 200px;height: 200px;object-fit: cover; background: url({{$configuration->logo != '' ? $configuration->logo : ''}});background-size: cover;background-position: center;">
                                        <label for="image-upload" id="image-label">Choose Logo</label>
                                        <input type="file" name="website_logo" id="image-upload" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Admin E-mail</label>
                                    <input type="text" name="new_email" class="form-control" value="{{$user->email != '' ? $user->email : ''}}">
                                    <div class="invalid-feedback" id="new_email"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Admin New Password</label>
                                    <input type="password" name="new_password" class="form-control" value="">
                                    <div class="invalid-feedback" id="new_password"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Website Name</label>
                                    <input type="text" name="website_name" class="form-control" value="{{$configuration->name != '' ? $configuration->name : ''}}">
                                    <div class="invalid-feedback" id="website_name"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Website Email</label>
                                    <input type="text" name="website_email" class="form-control" value="{{$configuration->email != '' ? $configuration->email : ''}}">
                                    <div class="invalid-feedback" id="website_email"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Copyright</label>
                                    <input type="text" name="copyright" class="form-control" value="{{$configuration->copyright != '' ? $configuration->copyright : ''}}">
                                    <div class="invalid-feedback" id="copyright"></div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary submit-general">Save Changes</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="defaults" role="tabpanel" aria-labelledby="defaults-tab">
                    <div class="p-20">
                        <h5>Default Settings</h5>
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar" aria-selected="true">Avatar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cover-tab" data-toggle="tab" href="#cover" role="tab" aria-controls="cover" aria-selected="false">Cover Photo</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                                <div class="p-20">
                                    <form id="avatar-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="avatar">Default Avatar Profile</label>
                                                <div id="avatar-preview" style="border-radius: 50%;width: 150px;height: 150px;object-fit: cover; background: url({{$defaults->avatar != '' ? $defaults->avatar : ''}});background-size: cover;background-position: center;">
                                                    <label for="avatar-upload" id="avatar-label">Choose Avatar</label>
                                                    <input type="file" name="avatar" id="avatar-upload" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary submit-avatar-form">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="cover" role="tabpanel" aria-labelledby="cover-tab">
                                <div class="p-20">
                                    <form id="cover-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="cover">Default Profile Cover</label>
                                                <div id="cover-preview" style="width: 500px;height: 250px;object-fit: cover; background: url({{$defaults->cover != '' ? $defaults->cover : ''}});background-size: cover;background-position: center;">
                                                    <label for="cover-upload" id="cover-label">Choose Cover</label>
                                                    <input type="file" name="cover" id="cover-upload" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary submit-cover-form">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links-tab">
                    <div class="p-20">
                        <h5>Social Links <i class="ti-link"></i></h5>
                        <form id="social-links-form">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="facebook">Facebook</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">facebook.com/</div>
                                        </div>
                                        <input type="text" class="form-control" name="facebook_link" value="{{ unserialize($configuration->social_media_links)['facebook'] != '' ? unserialize($configuration->social_media_links)['facebook'] : ''}}">
                                        <div class="invalid-feedback" id="facebook_link"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pinterest">Pinterest</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">pinterest.com/</div>
                                        </div>
                                        <input type="text" class="form-control" name="pinterest_link" value="{{ unserialize($configuration->social_media_links)['pinterest'] != '' ? unserialize($configuration->social_media_links)['pinterest'] : ''}}">
                                        <div class="invalid-feedback" id="pinterest_link"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="twitter">Twitter</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">twitter.com/</div>
                                        </div>
                                        <input type="text" class="form-control" name="twitter_link" value="{{ unserialize($configuration->social_media_links)['twitter'] != '' ? unserialize($configuration->social_media_links)['twitter'] : ''}}">
                                        <div class="invalid-feedback" id="twitter_link"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="linkedin">Linkedin</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">linkedin.com/</div>
                                        </div>
                                        <input type="text" class="form-control" name="linkedin_link" value="{{ unserialize($configuration->social_media_links)['linkedin'] != '' ? unserialize($configuration->social_media_links)['linkedin'] : ''}}">
                                        <div class="invalid-feedback" id="linkedin_link"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="google">Google Plus</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">plus.google.com/</div>
                                        </div>
                                        <input type="text" class="form-control" name="google_link" value="{{ unserialize($configuration->social_media_links)['google'] != '' ? unserialize($configuration->social_media_links)['google'] : ''}}">
                                        <div class="invalid-feedback" id="google_link"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="instagram">Instagram</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">instagram.com/</div>
                                        </div>
                                        <input type="text" class="form-control" name="instagram_link" value="{{ unserialize($configuration->social_media_links)['instagram'] != '' ? unserialize($configuration->social_media_links)['instagram'] : ''}}">
                                        <div class="invalid-feedback" id="instagram_link"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary submit-social-links">Save Changes</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="api-keys" role="tabpanel" aria-labelledby="api-keys-tab">
                    <div class="p-20">
                        <h5>API Keys <i class="ti-key"></i></h5>
                        <ul class="nav nav-tabs" id="myTab1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="filestack-tab" data-toggle="tab" href="#filestack" role="tab" aria-controls="filestack" aria-selected="true">Filestack</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cloudinary-tab" data-toggle="tab" href="#cloudinary" role="tab" aria-controls="cloudinary" aria-selected="false">Cloudinary</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent1">
                            <div class="tab-pane fade show active" id="filestack" role="tabpanel" aria-labelledby="filestack-tab">
                                <div class="p-20">
                                    <h5>Filestack API <i class="ti-layers-alt"></i></h5>
                                    <form id="filestack-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">API Key</label>
                                                <input type="text" name="api_key" class="form-control" value="{{ unserialize($configuration->filestack_api)['api_key'] != '' ? unserialize($configuration->filestack_api)['api_key'] : ''}}">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary submit-filestack-form">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="cloudinary" role="tabpanel" aria-labelledby="cloudinary-tab">
                                <div class="p-20">
                                    <h5>Cloudinary API <i class="ti-cloud-up"></i></h5>
                                    <form id="cloudinary-form">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">Cloud Name</label>
                                                <input type="text" name="cloud_name" class="form-control" value="{{ unserialize($configuration->cloudinary_api)['cloud_name'] != '' ? unserialize($configuration->cloudinary_api)['cloud_name'] : ''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">API Key</label>
                                                <input type="text" name="api_key" class="form-control" value="{{ unserialize($configuration->cloudinary_api)['api_key'] != '' ? unserialize($configuration->cloudinary_api)['api_key'] : ''}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">API Secret</label>
                                                <input type="text" name="api_secret" class="form-control" value="{{ unserialize($configuration->cloudinary_api)['api_secret'] != '' ? unserialize($configuration->cloudinary_api)['api_secret'] : ''}}">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary submit-cloudinary-form">Save Changes</button>
                                    </form>
                                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<script>
    $.uploadPreview({
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#avatar-upload",   // Default: .image-upload
        preview_box: "#avatar-preview",  // Default: .image-preview
        label_field: "#avatar-label",    // Default: .image-label
        label_default: "Choose Avatar",   // Default: Choose File
        label_selected: "Replace Avatar",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#cover-upload",   // Default: .image-upload
        preview_box: "#cover-preview",  // Default: .image-preview
        label_field: "#cover-label",    // Default: .image-label
        label_default: "Choose Cover",   // Default: Choose File
        label_selected: "Replace Cover",  // Default: Change File
        no_label: false                 // Default: false
    });
    $(".submit-cover-form").click(function(){
        if($('#cover-upload').get(0).files.length){
            var formData = new FormData($('#cover-form')[0]);
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url'      : "{!! URL('admin/settings/default-cover') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : formData,
                'processData': false,
                'contentType': false,
                success    : function(data){
                    // Remove error
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').hide();
                    if(data.result == 'success'){
                        noty({
                            theme: 'app-noty',
                            text: 'Successfully saved changes!',
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
                    else{
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
                            }
                        });
                    }
                },
                beforeSend: function(){
                    $(".submit-cover-form").text('Saving..')
                    $(".submit-cover-form").attr('disabled', true)
                },
                complete: function(){
                    $(".submit-cover-form").text('Save Changes')
                    $(".submit-cover-form").attr('disabled', false)
                }
            });
            return false;
        }else{
            return false;
        }
    });
    $(".submit-avatar-form").click(function(){
        if($('#avatar-upload').get(0).files.length){
            var formData = new FormData($('#avatar-form')[0]);
            $.ajax({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url'      : "{!! URL('admin/settings/default-avatar') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : formData,
                'processData': false,
                'contentType': false,
                success    : function(data){
                    // Remove error
                    $('.form-control').removeClass('is-invalid');
                    $('.invalid-feedback').hide();
                    if(data.result == 'success'){
                        noty({
                            theme: 'app-noty',
                            text: 'Successfully saved changes!',
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
                    else{
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
                            }
                        });
                    }
                },
                beforeSend: function(){
                    $(".submit-avatar-form").text('Saving..')
                    $(".submit-avatar-form").attr('disabled', true)
                },
                complete: function(){
                    $(".submit-avatar-form").text('Save Changes')
                    $(".submit-avatar-form").attr('disabled', false)
                }
            });
            return false;
        }else{
            return false;
        }
    });
    $(".submit-cloudinary-form").click(function(){
        var formData = new FormData($('#cloudinary-form')[0]);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/settings/cloudinary') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                // Remove error
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                if(data.result == 'success'){
                    noty({
                        theme: 'app-noty',
                        text: 'Successfully saved changes!',
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
                else{
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
                        }
                    });
                }
            },
            beforeSend: function(){
                $(".submit-cloudinary-form").text('Saving..')
                $(".submit-cloudinary-form").attr('disabled', true)
            },
            complete: function(){
                $(".submit-cloudinary-form").text('Save Changes')
                $(".submit-cloudinary-form").attr('disabled', false)
            }
        });
        return false;
    });
    $(".submit-filestack-form").click(function(){
        var formData = new FormData($('#filestack-form')[0]);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/settings/filestack') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                // Remove error
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                if(data.result == 'success'){
                    noty({
                        theme: 'app-noty',
                        text: 'Successfully saved changes!',
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
                else{
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
                        }
                    });
                }
            },
            beforeSend: function(){
                $(".submit-filestack-form").text('Saving..')
                $(".submit-filestack-form").attr('disabled', true)
            },
            complete: function(){
                $(".submit-filestack-form").text('Save Changes')
                $(".submit-filestack-form").attr('disabled', false)
            }
        });
        return false;
    });
    $(".submit-social-links").click(function(){
        var formData = new FormData($('#social-links-form')[0]);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/settings/social') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                // Remove error
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                if(data.result == 'success'){
                    noty({
                        theme: 'app-noty',
                        text: 'Successfully saved changes!',
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
                else{
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
                        }
                    });
                }
            },
            beforeSend: function(){
                $(".submit-social-links").text('Saving..')
                $(".submit-social-links").attr('disabled', true)
            },
            complete: function(){
                $(".submit-social-links").text('Save Changes')
                $(".submit-social-links").attr('disabled', false)
            }
        });
        return false;
    });
    $(".submit-general").click(function(){
        var formData = new FormData($('#general-form')[0]);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/settings/general') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                // Remove error
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').hide();
                if(data.result == 'success'){
                    noty({
                        theme: 'app-noty',
                        text: 'Successfully saved changes!',
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
                else{
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
                        }
                    });
                }
            },
            beforeSend: function(){
                $(".submit-general").text('Saving..')
                $(".submit-general").attr('disabled', true)
            },
            complete: function(){
                $(".submit-general").text('Save Changes')
                $(".submit-general").attr('disabled', false)
            }
        });
        return false;
    });
</script>
@stop