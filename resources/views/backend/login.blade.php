@extends('backend.layout')
@section('title','Login')
@section('content')
<h4 class="fw-300 c-grey-900 mB-40">Login</h4>
<form class="login-form">
    <div class="alert alert-primary alert-dismissible fade show d-none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
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
    <div class="form-group">
        <label for="email" class="text-normal text-dark">Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        <div class="invalid-feedback" id="email"></div>
    </div>
    <div class="form-group">
        <label for="password" class="text-normal text-dark">Password</label>
        <input type="password" class="form-control" name="password" required>
        <div class="invalid-feedback" id="password"></div>
    </div>
    <div class="form-group">
        <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                    <input type="checkbox" id="remember" name="remember" class="peer" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class=" peers peer-greed js-sb ai-c">
                        <span class="peer peer-greed">Remember Me</span>
                    </label>
                </div>
            </div>
            <div class="peer">
                <button type="button" class="btn btn-primary submit-form">Login</button>
            </div>
        </div>
    </div>
    <div class="peers ai-c jc-sb fxw-nw">
        <div class="peer">
            <a class="btn btn-link" href="{{ URL('admin/forgot-password') }}">
                Forgot Your Password?
            </a>
        </div>
    </div>
    {{ csrf_field() }}
</form>
@stop
@section('js')
<script>
    $(".submit-form").click(function(){
        var form = $('.login-form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'         : "{!! URL('admin/login') !!}",
            'method'      : 'post',
            'dataType'    : 'json',
            'data'        : formData,
            'processData' : false,
            'contentType'   : false,
            success    : function(data){
                $('.alert-danger').addClass('d-none');
                $(".invalid-feedback").empty();
                $("input").removeClass('is-invalid');
                if(data.result == 'success'){
                    $('.alert-primary').addClass('d-none');
                    $('.alert-danger').addClass('d-none');
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').text('Login successful! Redirecting..');
                    if(data.uri == ''){
                        window.location.reload();
                    }else{
                        window.location = data.uri;
                    }
                }else if(data.result == 'invalid'){
                    $('.alert-primary').addClass('d-none');
                    $('.alert-success').addClass('d-none');
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text('Sorry! We can\'t find your account..');
                    $("input[name=email]").addClass("is-invalid");
                    $("input[name=password]").addClass("is-invalid");
                }else{
                    $('.alert-success').addClass('d-none');
                    $('.alert-primary').addClass('d-none');
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text('Please check your inputs and try again..');
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
                $('.alert-danger').addClass('d-none');
                $('.alert-primary').removeClass('d-none');
                $('.alert-primary').text('Authenticating..');
                $('.submit-form').attr('disabled', true);
                $('.submit-form').text('Logging in..');
            },
            complete: function(){
                $('.submit-form').attr('disabled', false);
                $('.submit-form').text('Login');
            }
        });
        return false;
    });
</script>
@stop