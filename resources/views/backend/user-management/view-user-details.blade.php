
@extends('admin-interface.layout')
@section('title','User Management')
@section('content')

@section('breadcrumb')
    <li><a href="{{url('admin/user-management')}}">User Management</a></li>
    <li class="active">{{$user->first_name.' '.$user->last_name}}'s Profile</li>
@stop

@section('content')
@include('admin-interface.includes.flash-message')
 <div class="panel-heading">
    <ul class="panel-controls">
        <li data-toggle="tooltip" data-placement="left" title="Back">
            <a href="{!! URL('admin/user-management/') !!}"><span class="fa fa-backward"></span></a>
        </li>
    </ul>
</div>

<div class="row">
     <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body profile" style="background-color: black;">
                <div class="profile-image">
                    <img src="{{url('uploads/profile_picture/'.$user->profile_picture)}}" alt="{{$user->first_name.' '.$user->last_name}}"/>
                </div>
                <?php $user_plan = App\Plan::find($user->plan); ?>
                <div class="profile-data">
                    <div class="profile-data-name">{{$user->first_name.' '.$user->last_name}}</div>
                    <div class="profile-data-title" style="color: #FFF;">{{$user_plan->name}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">  
            <div class="panel-heading">
                <h3 class="panel-title">Profile Information</h3>
                <div class="right pull-right">
                <select class="form-control change-account-status" name="section" data-id="{!!Crypt::encrypt($user->id)!!}" data-name="{!!$user->first_name.' '.$user->last_name!!}">
                        <option value="unblock" @if($user->account_status == 0) selected="selected" disabled @endif id="unblock-account" data-location="{!! URL('admin/user-management/unblock/'.Crypt::encrypt($user->id)) !!}">@if($user->account_status == 0) Active @elseif($user->account_status == 1) Unblock {!!$user->first_name!!}'s Account @endif</option>
                        <option value="block" @if($user->account_status == 1) selected="selected" disabled @endif id="block-account" data-location="{!! URL('admin/user-management/block/'.Crypt::encrypt($user->id)) !!}">@if($user->account_status == 0) Block {!!$user->first_name!!}'s Account @elseif($user->account_status == 1) Account Blocked @endif</option>
                        <option value="remove" id="remove-account" data-location="{!! URL('admin/user-management/remove/'.Crypt::encrypt($user->id)) !!}">Remove {!!$user->first_name!!}'s Account</option>
                </select>
            </div>
            </div>                 
             <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Full Name</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">{{$user->first_name.' '.$user->last_name}} @if($user->account_status == 0) <span class="label label-success">Active</span> @elseif($user->account_status == 1) <span class="label label-danger">Blocked</span> @endif</label> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Email</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">{{$user->email}}</label> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Membership</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">{{$user_plan->name}}</label> 
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Registered Since</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">{{$user->created_at->toFormattedDateString()}}</label> 
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Activation Status</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">@if($user->status == 1) Verified @elseif($user->status == 0) Pending @endif</label> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Usage Information</h3>
            </div>       
             <div class="panel-body">
                <?php $percentage = ($usage->current_usage / $usage->total_usage) * 100; ?>
                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Current Usage</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">{{App\Models\Helper::bytesToHuman($usage->current_usage)}} ({{number_format($percentage, 0)}}%) of {{App\Models\Helper::bytesToHuman($usage->total_usage)}} used </label> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 col-xs-12 control-label">Galleries Owned</label>
                    <div class="col-md-10 col-xs-12">
                      <label class="col-md-6 col-xs-12 control-label">{{count($user->galleries)}}</label> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop
@section('js')
    <script>
        $('.change-account-status').change(function(e){
			var name = $(this).data('name');
			var account_status = $(this).val();
			var uid = $(this).data('id');
            if(account_status == 'unblock'){
                var location = $('#unblock-account').data("location");
                swal({
                    title             : "Are you sure?",
                    text              : "You are about to unblock this user!",
                    type              : "warning",
                    showCancelButton  : true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText : "Yes, Unblock Account!",
                    cancelButtonText  : "No, cancel it!",
                    closeOnConfirm    : false,
                    closeOnCancel     : false 
                }, function(isConfirm){
                    if(isConfirm){
                        setTimeout(function(){
                            window.location = location;
                        }, 800);
                    }
                    else{
                        swal.close();
                    }
                });
            }
            if(account_status == 'block'){
                var location = $('#block-account').data("location");
                swal({
                    html: true,
                    title             : "Are you sure?",
                    text              : "This will <b>temporarily block "+ name +"</b> from accessing the site. Continue?",
                    type              : "warning",
                    showCancelButton  : true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText : "Yes, Block Account!",
                    cancelButtonText  : "No, cancel it!",
                    closeOnConfirm    : false,
                    closeOnCancel     : false 
                }, function(isConfirm){
                    if(isConfirm){
                        setTimeout(function(){
                            window.location = location;
                        }, 800);
                    }
                    else{
                        swal.close();
                    }
                });
            }
            if(account_status == 'remove'){
                var location = $('#remove-account').data("location");
                swal({
                    html: true,
                    title: "Are you sure?",
                    text: "You are about to <b>permanently delete "+ name +"'s account and all its data</b>. You will not be able to recover this account. This operation cannot be undone. Type '<b>DELETE</b>' to confirm.",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText : "Delete Account",
                    cancelButtonText  : "Cancel",
                    inputPlaceholder: "DELETE"
                    },
                    function(inputValue){
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError("Type 'DELETE' to confirm");
                        return false
                    }

                    if (inputValue === "DELETE") {
                        setTimeout(function(){
                            window.location = location;
                        }, 800);
                    }else{
                        swal.showInputError("Type 'DELETE' to confirm");
                        return false
                    }
                });
            }
            /*if(account_status == 'remove'){
                var location = $('#remove-account').data("location");
                swal({
                    title             : "Are you sure?",
                    text              : "All data related to "+ name +" will be lost. This cannot be undone! Continue?",
                    type              : "warning",
                    showCancelButton  : true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText : "Yes, remove it!",
                    cancelButtonText  : "No, cancel it!",
                    closeOnConfirm    : false,
                    closeOnCancel     : false 
                }, function(isConfirm){
                    if(isConfirm){
                        setTimeout(function(){
                            window.location = location;
                        }, 800);
                    }
                    else{
                        swal.close();
                    }
                });
            }*/
		});
    </script>
@stop