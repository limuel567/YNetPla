@extends('backend.layout')
@section('title','Forgot Password')
@section('content')
<h4 class="fw-300 c-grey-900">Forgot your password?</h4>
<div class="alert alert-success alert-dismissible fade show d-none" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="forgot-password">
    <p>Don't worry. Resetting your password is easy, just tell us the email address you registered with YNetPla.</p>
    <div class="form-group">
        <input type="email" name="email" value="{!! old('email') !!}" class="form-control" placeholder="Email address" required autofocus/>
        <div class="invalid-feedback" id="email"></div>
    </div>
    <div class="form-group">
        <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
                <a href="{!! URL('admin') !!}" class="btn btn-link btn-block">Return to login page</a>
            </div>
            <div class="peer">
                <button type="button" class="btn btn-primary submit-form">Send</button>
            </div>
        </div>
    </div>
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
            'url'      : "{!! URL('admin/forgot-password') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : $('#forgot-password').serialize(),
            success    : function(data){
                $(".invalid-feedback").empty();
                $("input").removeClass('is-invalid');
                if(data.result == 'success'){
                    $('#forgot-password > p').remove();
                    $('.submit-form').remove();
                    $('input[name=email]').remove();
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').text('We have sent you an email with reset instructions.');
                }else if(data.result == 'invalid'){
                    $('.alert-success').addClass('d-none');
                    $("input[name=email]").addClass("is-invalid");
                }else{
                    $('.alert-success').addClass('d-none');
                    $.each(data.errors,function(key,value){
                        if(value != ""){
                            $("#"+key).show();
                            $("#"+key).text(value);
                            $("input[name="+key+"]").addClass("is-invalid");
                            $("input[name="+key+"]").focus();
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