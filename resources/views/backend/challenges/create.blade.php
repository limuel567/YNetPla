@extends('backend.default')
@section('title',$label == 'Edit' ? 'Edit Subscription ~ YNetPla Admin' : 'Create Subscription ~ YNetPla Admin')
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <div class="bgc-white p-20 bd">
            <h4 class="c-grey-900">@if($label == 'Add') Create Subscription Plan @else Edit {{ucwords($subscription->name)}} Subscription Plan @endif</h4>
            <div class="mT-30">
                <form id="create-plan">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Subscription Plan Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Subscription Plan Name" value="@if($label == 'Edit') {{$subscription->name}}@endif">
                            <div class="invalid-feedback" id="name"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="subscription_type">Subscription Plan Type</label>
                            <select name="subscription_type" class="form-control"> 
                                <option value="0" @if($label == 'Edit') @if($subscription->subscription_type == 0) selected @endif @endif>Free</option>
                                <option value="1" @if($label == 'Edit') @if($subscription->subscription_type == 1) selected @endif @endif>Trial</option>
                                <option value="2" @if($label == 'Edit') @if($subscription->subscription_type == 2) selected @endif @endif>Pay</option>
                            </select>
                            <div class="invalid-feedback" id="subscription_type"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="subscription_period">Subscription Plan Period</label>
                            <input type="number" required name="subscription_period" min="1" max="999" class="form-control subscription_period" placeholder="Default. 60" value="@if($label == 'Edit'){!!$subscription->subscription_period!!}@endif">
                            <div class="invalid-feedback" id="subscription_period"></div>
                        </div>
                    </div>
                    @if($subscription->id != 8)
                    <div class="form-row">
                        <label for="description">Plan Description</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[0])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[1])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[2])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[3])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[4])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[5])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[6])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[7])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[8])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[9])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[10])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[11])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[12])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[13])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <textarea rows="4" name="description[]" class="form-control" placeholder="Plan Description">@if($label == 'Edit'){!!htmlentities($description[14])!!}@endif</textarea>
                            <div class="invalid-feedback" id="description"></div>
                        </div>
                    </div>
                    @endif
                    <input type="hidden" name="id" class="form-control" value="@if($label == 'Edit'){{Crypt::encrypt($subscription->id)}}@endif">
                    <button type="button" class="btn btn-primary submit-plan">Submit Plan</button>
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
    $(".subscription_period").keyup(function() {
        setTimeout(function(){
            if($(".subscription_period").val() < 1){
                $(".subscription_period").val(1); 
            }
        }, 1000);
    });
    $('.submit-plan').click(function(){
        var formData = new FormData($('#create-plan')[0]);
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url'      : "{!! URL('admin/subscription/create') !!}",
            'method'   : 'post',
            'dataType' : 'json',
            'data'     : formData,
            'processData': false,
            'contentType': false,
            success    : function(data){
                $(".invalid-feedback").empty();
                $("input").removeClass('is-invalid');
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
                        }
                    });
                }
            },
            beforeSend: function(){
                $('.submit-plan').attr('disabled', true);
                $('.submit-plan').text('Creating..');
            },
            complete: function(){
                $('.submit-plan').attr('disabled', false);
                $('.submit-plan').text('Submit plan');
            }
        });
        return false;
    });
</script>
@stop