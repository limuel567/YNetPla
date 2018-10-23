@extends('backend.layout')
@section('title','Reset Password')
@section('content')
<h4 class="fw-300 c-grey-900">Reset your password</h4>
<div class="alert alert-success alert-dismissible fade show d-none" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="reset-password">
    <p>Enter a new password for your account.</p>
    <div class="form-group">
        <input type="password" name="new_password" value="{!! old('new_password') !!}" class="form-control" placeholder="New Password" required/>
        <div class="invalid-feedback" id="new_password"></div>
    </div>
    <div class="form-group">
        <input type="password" name="new_password_confirmation" value="{!! old('new_password_confirmation') !!}" class="form-control" placeholder="Confirm New Password" required/>
        <div class="invalid-feedback" id="new_password_confirmation"></div>
    </div>
    <div class="form-group">
        <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
                <a href="{!! URL('admin') !!}" class="btn btn-link btn-block">Return to login page</a>
            </div>
            <div class="peer">
                <button type="button" class="btn btn-primary submit-form">Reset Password</button>
            </div>
        </div>
    </div>
    <input type="hidden" value="{!! $reset_id !!}" name="id">
    {!! csrf_field() !!}
</form>
@stop
@section('js')
<script>
    $(".submit-form").click(function(){
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/reset-password') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : $('#reset-password').serialize(),
            success    : function(data){
                $(".invalid-feedback").empty();
                $("input").removeClass('is-invalid');
                if(data.result == 'success'){
                    $('#reset-password > p').remove();
                    $('.submit-form').remove();
                    $('input[name=new_password]').remove();
                    $('input[name=new_password_confirmation]').remove();
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').text('Success! Password reset succeeded.');
                }else if(data.result == 'invalid'){
                    $('#reset-password').remove();
                    $('.alert-success').addClass('d-none');
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').html('Sorry! We cannot process your request at this moment. <a href="{{URL("admin")}}">Go to login</a>');
                }else{
                    $('.alert-success').addClass('d-none');
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
                $('.alert-success').addClass('d-none');
                $('.submit-form').attr('disabled', true);
                $('.submit-form').text('Sending..');
            },
            complete: function(){
                $('.submit-form').attr('disabled', false);
                $('.submit-form').text('Send');
            }
        });
        return false;
    });
</script>
@stop