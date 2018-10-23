@extends('admin-interface.layout')
@section('title',$label.' User')
@section('page_title')
	<h2><span class="fa fa-user"></span> <span id="page-title">@if($label == 'Edit') {!! ucwords($user->first_name.' '.$user->last_name) !!}'s Information @else {!! $label.' User' !!} @endif</span></h2>
@stop
@section('breadcrumb')
	<li><a href="{!! URL('admin/user-management') !!}">Users Management</a></li>
    <li class="active">{!! $label !!} User</li>
@stop
@section('content')
	<div class="row">
	    <div class="col-md-12">  
		    <div class="panel panel-default">
		        <div class="panel-heading">
		            <h3 class="panel-title">This is where you can {!! $label == 'Add' ? 'add' : 'edit' !!} a user</h3>
		            <ul class="panel-controls">
		                <li data-toggle="tooltip" data-placement="left" title="Back">
		                	<a href="{!! URL('admin/user-management') !!}">
			                	<span class="fa fa-backward"></span>
			                </a>
		                </li>
		            </ul> 
		        </div>
		       	<div class="form-horizontal">
			        <div class="panel-body">
			    	    <div class="row">
			                <div class="panel panel-default tabs">
			                    <ul class="nav nav-tabs" role="tablist">
			                    	@if($label == 'Edit')
				                    	<li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
										<li><a href="#credentials" role="tab" data-toggle="tab">Credentials</a></li>
									@else
										<li class="active"><a href="#information" role="tab" data-toggle="tab">Information</a></li>
									@endif
			                    </ul>                            
			                    <div class="panel-body tab-content">
			                    	@if($label == 'Edit')
			                    		<!-- General -->
				                        <div class="tab-pane active" id="general">
				                        	<form id="general-form">
			                                    <div class="form-group general-group">
							                        <label class="col-md-2 col-xs-12 control-label">Privilege</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <select class="form-control" name="privilege">
			                                                <option value="1" {!! $user->privilege == 1 ? 'selected' : '' !!}>User</option>
			                                                <option value="0" {!! $user->privilege == 0 ? 'selected' : '' !!}>Admin</option>
			                                            </select>
							                            <span style="color:red" class="general-error" id="privilege"></span>
							                        </div>
							                    </div>
							                    <div class="form-group general-group">
							                        <label class="col-md-2 col-xs-12 control-label">Profile Picture</label>
							                        <div class="col-md-8 col-xs-12">
							                            <input type="file" class="file-simple file_picture" accept="image/jpg,image/png,image/gif" name="profile_picture" data-file="file_picture" data-value="{!!$user->profile_picture!!}"/>
							                            <span style="color:red" class="general-error" id="profile_picture"></span>
							                        </div>
							                    </div>
												<div class="form-group general-group">
							                        <label class="col-md-2 col-xs-12 control-label">First Name</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="first_name" class="form-control" value="{!! htmlentities($user->first_name) !!}"/>
							                            <span style="color:red" class="general-error" id="first_name"></span>
							                        </div>
							                    </div>
							                    <div class="form-group general-group">
							                        <label class="col-md-2 col-xs-12 control-label">Last Name</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="last_name" class="form-control" value="{!! htmlentities($user->last_name) !!}"/>
							                            <span style="color:red" class="general-error" id="last_name"></span>
							                        </div>
							                    </div>
							                    <div class="form-group general-group client-display">
							                        <label class="col-md-2 col-xs-12 control-label">Username</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="username" class="form-control client-value" value="{!! $user->username !!}"/>
							                            <span style="color:red" class="general-error client-error" id="username"></span>
							                        </div>
							                    </div>
							                    <div class="form-group general-group">
									                <div class="col-md-10">
										            	<button class="btn btn-primary pull-right">Save</button>
										            </div>
										        </div>
										        <input type="hidden" value="{!! Crypt::encrypt($user->id) !!}" name="id">
										        {!! csrf_field() !!}
										    </form>
				                        </div>
								        <!-- Credentials -->
								        <div class="tab-pane" id="credentials">
								        	<form id="credentials-form">
												<div class="form-group credentials-group">
							                        <label class="col-md-2 col-xs-12 control-label">Email</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="email" class="form-control" value="{!! $user->email !!}"/>
							                            <span style="color:red" class="credentials-error" id="email"></span>
							                        </div>
							                    </div>
							                    <div class="form-group credentials-group">
							                        <label class="col-md-2 col-xs-12 control-label">Password</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="password" name="password" class="form-control" value="{!! Crypt::decrypt($user->crypted_password) !!}"/>
							                            <span style="color:red" class="credentials-error" id="password"></span>
							                        </div>
							                    </div>
										       	<div class="form-group credentials-group">
									                <div class="col-md-10">
										            	<button class="btn btn-primary pull-right">Save</button>
										            </div>
										        </div>
										        <input type="hidden" value="{!! Crypt::encrypt($user->id) !!}" name="id">
										        {!! csrf_field() !!}
										    </form>
									    </div>
			                        @else
								        <div class="tab-pane active" id="information">
								        	<form id="information-form">
								        		<div class="form-group information-group">
							                        <label class="col-md-2 col-xs-12 control-label">Privilege</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <select class="form-control" name="privilege">
			                                                <option value="1">User</option>
			                                                <option value="0">Admin</option>
			                                            </select>
							                            <span style="color:red" class="general-error" id="privilege"></span>
							                        </div>
							                    </div>
								        		<div class="form-group information-group">
							                        <label class="col-md-2 col-xs-12 control-label">First Name</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="first_name" class="form-control"/>
							                            <span style="color:red" class="information-error" id="first_name"></span>
							                        </div>
							                    </div>
							                    <div class="form-group information-group">
							                        <label class="col-md-2 col-xs-12 control-label">Last Name</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="last_name" class="form-control"/>
							                            <span style="color:red" class="information-error" id="last_name"></span>
							                        </div>
							                    </div>
							                    <div class="form-group information-group client-display">
							                        <label class="col-md-2 col-xs-12 control-label">Username</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="username" class="form-control client-value"/>
							                            <span style="color:red" class="information-error client-error" id="username"></span>
							                        </div>
							                    </div>
												<div class="form-group information-group">
							                        <label class="col-md-2 col-xs-12 control-label">Email</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="text" name="email" class="form-control"/>
							                            <span style="color:red" class="information-error" id="email"></span>
							                        </div>
							                    </div>
							                    <div class="form-group information-group">
							                        <label class="col-md-2 col-xs-12 control-label">Password</label>
							                        <div class="col-md-8 col-xs-12"> 
							                            <input type="password" name="password" class="form-control"/>
							                            <span style="color:red" class="information-error" id="password"></span>
							                        </div>
							                    </div>
										       	<div class="form-group information-group">
									                <div class="col-md-10">
										            	<button class="btn btn-primary pull-right">Save</button>
										            </div>
										        </div>
										        {!! csrf_field() !!}
										    </form>
									    </div>
			                        @endif
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
	<script type="text/javascript" src="{!!asset('admin-interface/js/plugins/fileinput/fileinput.min.js')!!}"></script>
	<script type="text/javascript">
		// Trigger privilege
		$(document).on('change',"select[name='privilege']",function(){
			switch($(this).val()){
				// Admin
			    case '0':
			        $(".client-display").hide();
			        $(".client-display").removeClass('has-error');
			        $(".client-value").val("");
			        $(".client-error").empty();
			        break;
			    // User
			    case '1':
			    	$(".client-display").show();
			        break;
			}
		})
		@if($label == 'Edit')
			// Page load
			switch($("select[name='privilege']").val()){
				// Admin
			    case '0':
			        $(".client-display").hide();
			        $(".client-display").removeClass('has-error');
			        $(".client-value").val("");
			        $(".client-error").empty();
			        $(".social-display").hide();
			        break;
			    // User
			    case '1':
			    	$(".client-display").show();
			        break;
			}
			// This is for the existing fields
			$('.file-simple').each(function(){
				var file = "<img src='{!!asset('/')!!}"+$(this).data('value')+"' class='file-preview-image' style='width:100%'>"
				$("."+$(this).data('file')).fileinput({
				        showUpload  : false,
				        showCaption : false,
				        browseClass : "btn btn-info",
				        showRemove  : false,
				        showClose   : false,
				        initialPreview: [ file ],
			        	initialPreviewConfig: 	[{
										            width: '500px'                     
										        }],
				        allowedFileTypes     : ["image"],
				        allowedFileExtensions: ["jpg", "png", "gif"],
				        previewconfiguration :  {
				        							previewAsData: false,
										            image: 	{
										            			width: "100%"
										            		}
										        }
				});
			});
	        $("#general-form").on("submit", function(){
	        	$(".general-error").empty();
	        	$(".general-group").removeClass('has-error');
	        	var formData = new FormData($('#general-form')[0]);
	            $.ajax({
	                'url'        : "{!! URL('admin/user-management/edit') !!}",
	                'method'     : 'post',
	                'dataType'   : 'json',
	                'data'       : formData,
	                'processData': false,
	                'contentType': false,
	                success      : function(data){
	                    if(data.result == 'success'){
	                    	// Change the title
	                    	$("#page-title").html(data.name+"'s information");
	                        swal("Good Job!","General information has been updated.", "success");
	                    }
	                    else{
	                        swal("Action failed", "Please check your inputs or connection and try again.", "error");
	                        $.each(data.errors,function(key,value){
	                            if(value != ""){
	                            	$("#"+key).text(value).parents('.general-group').addClass('has-error');
	                            }
	                        });
	                    }
	                },
	                beforeSend : function(){
	                    $('#loadingDiv').show()
	                },
	                complete   : function(){
	                    $('#loadingDiv').hide();
	                }
	            });
	            return false;
	        });
	        $("#credentials-form").on("submit", function(){
	        	$(".credentials-error").empty();
	        	$(".credentials-group").removeClass('has-error');
	            $.ajax({
	                'url'        : "{!! URL('admin/user-management/credentials') !!}",
	                'method'     : 'post',
	                'dataType'   : 'json',
	                'data'       : $(this).serialize(),
	                success      : function(data){
	                    if(data.result == 'success'){
	                        swal("Good Job!","Credentials information has been updated.", "success");
	                    }
	                    else{
	                        swal("Action failed", "Please check your inputs or connection and try again.", "error");
	                        $.each(data.errors,function(key,value){
	                            if(value != ""){
	                            	$("#"+key).text(value).parents('.credentials-group').addClass('has-error');
	                            }
	                        });
	                    }
	                },
	                beforeSend : function(){
	                    $('#loadingDiv').show()
	                },
	                complete   : function(){
	                    $('#loadingDiv').hide();
	                }
	            });
	            return false;
	        });
			// Remove close
			$(".fileinput-remove").remove();
	    @else
	    	// Information form
	        $("#information-form").on("submit", function(){
	        	$(".information-error").empty();
	        	$(".information-group").removeClass('has-error');
	            $.ajax({
	                'url'        : "{!! URL('admin/user-management/add') !!}",
	                'method'     : 'post',
	                'dataType'   : 'json',
	                'data'       : $(this).serialize(),
	                success      : function(data){
	                    if(data.result == 'success'){
	                        window.location = data.url;
	                    }
	                    else{
	                        swal("Action failed", "Please check your inputs or connection and try again.", "error");
	                        $.each(data.errors,function(key,value){
	                            if(value != ""){
	                            	$("#"+key).text(value).parents('.information-group').addClass('has-error');
	                            }
	                        });
	                    }
	                },
	                beforeSend : function(){
	                    $('#loadingDiv').show()
	                },
	                complete   : function(){
	                    $('#loadingDiv').hide();
	                }
	            });
	            return false;
	        });
		@endif
	</script>
@stop