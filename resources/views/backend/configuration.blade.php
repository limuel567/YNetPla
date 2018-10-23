@extends('backend.default')
@section('title','Configuration')
@section('page_title')
	<h2><span class="fa fa-wrench"></span> Configuration</h2>
@stop
@section('breadcrumb')
    <li class="active">Configuration</li>
@stop
@section('content')
	<div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">This is where you can manage your configuration</h3>
        </div>     
        <div class="panel-body">
    	    <div class="row">
                <div class="panel panel-default tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#tab-general" role="tab" data-toggle="tab">General</a></li>
                        <li><a href="#tab-social-links" role="tab" data-toggle="tab">Social Links</a></li>
                        <li><a href="#tab-credentials" role="tab" data-toggle="tab">Credentials</a></li>
                        <li><a href="#tab-api-keys" role="tab" data-toggle="tab">API Keys</a></li>
                        <li><a href="#tab-other-charges" role="tab" data-toggle="tab">Other Charges</a></li>
                    </ul>
                    <div class="panel-body tab-content">
						<div class="tab-pane active" id="tab-general">
                        	<form class="form-horizontal" method="post" action="{!! URL('admin/configuration/general') !!}" enctype="multipart/form-data">
                        		<div class="form-group {!!$errors->first('website_logo') ? 'has-error' : ''!!}">
			                        <label class="col-md-2 col-xs-12 control-label">Website Logo</label>
			                        <div class="col-md-8 col-xs-12"> 
			                        <input type="file" class="file-simple1" name="website_logo" accept="image/*" value="@if(old('website_logo')){!! old('website_logo') !!}@else{!! $configuration->website_logo !!}@endif"/>
			                            <span class="help-block">{!!$errors->first('website_logo')!!}</span>
			                        </div>
			                    </div>
			                    <div class="form-group {!!$errors->first('profile_photo') ? 'has-error' : ''!!}">
			                        <label class="col-md-2 col-xs-12 control-label">Profile Picture</label>
			                        <div class="col-md-8 col-xs-12"> 
			                            <input type="file" class="file-simple2" name="profile_photo" accept="image/*" value="@if(old('profile_photo')){!! old('profile_photo') !!}@else{!! $user->profile_photo !!}@endif"/>
			                            <span class="help-block">{!!$errors->first('profile_photo')!!}</span>
			                        </div>
			                    </div>
			                    <div class="form-group {!!$errors->first('website_name') ? 'has-error' : ''!!}">
			                        <label class="col-md-2 col-xs-12 control-label">Website Name</label>
			                        <div class="col-md-8 col-xs-12">
		                                <input type="text" name="website_name" class="form-control" value="@if(old('website_name')){!! old('website_name') !!}@else{!! $configuration->website_name !!}@endif"/>
			                            <span class="help-block">{!!$errors->first('website_name')!!}</span>
			                        </div>
			                    </div>
			                    <div class="form-group {!!$errors->first('website_email') ? 'has-error' : ''!!}">
			                        <label class="col-md-2 col-xs-12 control-label">Website Email</label>
			                        <div class="col-md-8 col-xs-12">
			                            <input type="text" name="website_email" class="form-control" value="@if(old('website_email')){!! old('website_email') !!}@else{!! $configuration->website_email !!}@endif"/>
			                            <span class="help-block">{!!$errors->first('website_email')!!}</span>
			                        </div>
			                    </div>
			                    <div class="form-group {!!$errors->first('first_name') ? 'has-error' : ''!!}">
			                        <label class="col-md-2 col-xs-12 control-label">Full Name</label>
			                        <div class="col-md-8 col-xs-12">
		                                <input type="text" name="first_name" class="form-control" value="@if(old('first_name')){!! old('first_name') !!}@else{!! $user->full_name !!}@endif"/>
			                            <span class="help-block">{!!$errors->first('first_name')!!}</span>
			                        </div>
			                    </div>
			                    <div class="form-group {!!$errors->first('address') ? 'has-error' : ''!!}">
                                    <label class="col-md-2 col-xs-12 control-label">Address</label>
                                    <div class="col-md-8 col-xs-12"> 
										<textarea class="form-control" rows="5" name="address">@if(old('address')){!! old('address') !!}@else{!! $configuration->address !!}@endif</textarea>
										<span class="help-block">{!!$errors->first('address')!!}</span>
									</div>
								</div>
			                    <div class="form-group {!!$errors->first('copyright') ? 'has-error' : ''!!}">
			                        <label class="col-md-2 col-xs-12 control-label">Copyright</label>
			                        <div class="col-md-8 col-xs-12">
			                            <input type="text" name="copyright" class="form-control" value="@if(old('copyright')){!! old('copyright') !!}@else{!! $configuration->copyright !!}@endif"/>
			                            <span class="help-block">{!!$errors->first('copyright')!!}</span>
			                        </div>
			                    </div>
			                    {!!csrf_field()!!}
			                    <div class="form-group">
			                        <div class="col-md-10">
						            	<button class="btn btn-primary pull-right">Save</button>
						            </div>
						        </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab-social-links">
                        	<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Social Links URLs</h3>
                                </div>
                                <form class="form-horizontal" id="social-links-form">
	                                <div class="panel-body">
										<div class="form-group form-group-social-links">
		                                    <label class="col-md-2 col-xs-12 control-label">Facebook Link</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="facebook_link" class="form-control" value="{!! unserialize($configuration->social_media_links)['facebook'] !!}"/>
					                            <span class="help-block social-links-error" style="color:red" id="facebook_link"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-social-links">
		                                    <label class="col-md-2 col-xs-12 control-label">Google+ Link</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="google_plus_link" class="form-control" value="{!! unserialize($configuration->social_media_links)['google_plus'] !!}"/>
					                            <span class="help-block social-links-error" style="color:red" id="google_plus_link"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-social-links">
		                                    <label class="col-md-2 col-xs-12 control-label">Twitter Link</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="twitter_link" class="form-control" value="{!! unserialize($configuration->social_media_links)['twitter'] !!}"/>
					                            <span class="help-block social-links-error" style="color:red" id="twitter_link"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-social-links">
		                                    <label class="col-md-2 col-xs-12 control-label">Linkedin Link</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="linkedin_link" class="form-control" value="{!! unserialize($configuration->social_media_links)['linkedin'] !!}"/>
					                            <span class="help-block social-links-error" style="color:red" id="linkedin_link"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-credentials">
                    		<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Email</h3>
                                </div>
                                <form class="form-horizontal" id="email-form">
	                                <div class="panel-body">
	                                	<div class="form-group form-group-email">
		                                    <label class="col-md-2 col-xs-12 control-label">Current Email</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="current_email" class="form-control email-input"/>
					                            <span class="help-block email-error" style="color:red" id="current_email"></span>
					                        </div>
					                    </div>
	                                	<div class="form-group form-group-email">
		                                    <label class="col-md-2 col-xs-12 control-label">New Email</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="new_email" class="form-control email-input"/>
					                            <span class="help-block email-error" style="color:red" id="new_email"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-email">
		                                    <label class="col-md-2 col-xs-12 control-label">Email Confirmation</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="new_email_confirmation" class="form-control email-input"/>
					                            <span class="help-block email-error" style="color:red" id="new_email_confirmation"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>
                            </div>
	                        <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Password</h3>
                                </div>
                                <form class="form-horizontal" id="password-form">
	                                <div class="panel-body">
	                                	<div class="form-group form-group-password">
		                                    <label class="col-md-2 col-xs-12 control-label">Current Password</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="password" name="current_password" class="form-control password-input"/>
					                            <span class="help-block password-error" style="color:red" id="current_password"></span>
					                        </div>
					                    </div>
	                                	<div class="form-group form-group-password">
		                                    <label class="col-md-2 col-xs-12 control-label">New Password</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="password" name="new_password" class="form-control password-input"/>
					                            <span class="help-block password-error" style="color:red" id="new_password"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-password">
					                        <label class="col-md-2 col-xs-12 control-label">Password Confirmation</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="password" name="new_password_confirmation" class="form-control password-input"/>
					                            <span class="help-block password-error" style="color:red" id="new_password_confirmation"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>
                            </div>
                        </div>
						<div class="tab-pane" id="tab-api-keys">
							<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Stripe Account</h3>
                                </div>
                                <form class="form-horizontal" id="api-keys-form">
	                                <div class="panel-body">
	                                	<div class="form-group form-group-api-keys">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Test Secret Key
		                                    	<button type="button" class="btn question-btn"></button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="stripe_test_secret_key" class="form-control" value="{!! unserialize($configuration->stripe_account)['test_secret_key'] !!}"/>
					                            <span class="help-block api-keys-error" style="color:red" id="stripe_test_secret_key"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-api-keys">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Live Secret Key
		                                    	<button type="button" class="btn question-btn"></button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="stripe_live_secret_key" class="form-control" value="{!! unserialize($configuration->stripe_account)['live_secret_key'] !!}"/>
					                            <span class="help-block api-keys-error" style="color:red" id="stripe_live_secret_key"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-api-keys">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Test Client ID
		                                    	<button type="button" class="btn question-btn"></button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="stripe_test_client_id" class="form-control" value="{!! unserialize($configuration->stripe_account)['test_client_id'] !!}"/>
					                            <span class="help-block api-keys-error" style="color:red" id="stripe_test_client_id"></span>
					                        </div>
					                    </div>
					                    <div class="form-group form-group-api-keys">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Live Client ID
		                                    	<button type="button" class="btn question-btn"></button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="stripe_live_client_id" class="form-control" value="{!! unserialize($configuration->stripe_account)['live_client_id'] !!}"/>
					                            <span class="help-block api-keys-error" style="color:red" id="stripe_live_client_id"></span>
					                        </div>
					                    </div>
	                                	<div class="form-group form-group-api-keys">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Mode
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place the word 'sandbox' if the website is not yet live, or place the word 'live' if the website is on live">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="stripe_mode" class="form-control" value="{!! unserialize($configuration->stripe_account)['mode'] !!}"/>
					                            <span class="help-block api-keys-error" style="color:red" id="stripe_mode"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-other-charges">
                    		<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Other Charges</h3>
                                </div>
                                <form class="form-horizontal" id="other-charges-form">
	                                <div class="panel-body">
	                                	<div class="form-group form-group-lite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Processing Fee (%)
		                                    	{{--  <button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the bids unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>  --}}
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="processing_fee" class="form-control numbers_only" value="{!! $configuration->processing_fee !!}"/>
					                            <span class="help-block lite-plan-error" style="color:red" id="processing_fee"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>                           
                            </div>
	                        {{--  <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Professional Plan</h3>
                                </div>
                                <form class="form-horizontal" id="professional-plan-form">
                                	<!-- <div class="panel-body">
	                                	<div class="form-group form-group-professional-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">How much per month</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="month_professional_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['professional']['month'] !!}"/>
					                            <span class="help-block professional-plan-error" style="color:red" id="month_professional_plan"></span>
					                        </div>
					                    </div>
	                                </div> -->
	                                <div class="panel-body">
	                                	<div class="form-group form-group-professional-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Number of Bids
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the bids unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="number_of_bids_professional_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['professional']['bids'] !!}"/>
					                            <span class="help-block professional-plan-error" style="color:red" id="number_of_bids_professional_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-professional-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Number of Skills
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the skills unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="number_of_skills_professional_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['professional']['skills'] !!}"/>
					                            <span class="help-block professional-plan-error" style="color:red" id="number_of_skills_professional_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-professional-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Number of Services
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the services unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="number_of_services_professional_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['professional']['services'] !!}"/>
					                            <span class="help-block professional-plan-error" style="color:red" id="number_of_services_professional_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-professional-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">Percentage (%)</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="percentage_professional_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['professional']['percentage'] !!}"/>
					                            <span class="help-block professional-plan-error" style="color:red" id="percentage_professional_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-professional-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">Additional Tax</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="additional_tax_professional_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['professional']['additional_tax'] !!}"/>
					                            <span class="help-block professional-plan-error" style="color:red" id="additional_tax_professional_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>                               
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Elite Plan</h3>
                                </div>
                                <form class="form-horizontal" id="elite-plan-form">
                                	<!-- <div class="panel-body">
	                                	<div class="form-group form-group-elite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">How much per month</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="month_elite_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['elite']['month'] !!}"/>
					                            <span class="help-block elite-plan-error" style="color:red" id="month_elite_plan"></span>
					                        </div>
					                    </div>
	                                </div> -->
	                                <div class="panel-body">
	                                	<div class="form-group form-group-elite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Number of Bids
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the bids unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="number_of_bids_elite_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['elite']['bids'] !!}"/>
					                            <span class="help-block elite-plan-error" style="color:red" id="number_of_bids_elite_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-elite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Number of Skills
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the skills unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="number_of_skills_elite_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['elite']['skills'] !!}"/>
					                            <span class="help-block elite-plan-error" style="color:red" id="number_of_skills_elite_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-elite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">
		                                    	Number of Services
		                                    	<button type="button" class="btn question-btn"  data-container="body" data-toggle="popover" data-placement="top" data-content="Place 0 to make the services unlimited">
		                                    		<i class="fa fa-question-circle" aria-hidden="true"></i>
		                                    	</button>
		                                    </label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="number_of_services_elite_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['elite']['services'] !!}"/>
					                            <span class="help-block elite-plan-error" style="color:red" id="number_of_services_elite_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-elite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">Percentage (%)</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="percentage_elite_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['elite']['percentage'] !!}"/>
					                            <span class="help-block elite-plan-error" style="color:red" id="percentage_elite_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-body">
	                                	<div class="form-group form-group-elite-plan">
		                                    <label class="col-md-2 col-xs-12 control-label">Additional Tax</label>
					                        <div class="col-md-8 col-xs-12">
				                                <input type="text" name="additional_tax_elite_plan" class="form-control numbers_only" value="{!! unserialize($configuration->subscription_plan)['elite']['additional_tax'] !!}"/>
					                            <span class="help-block elite-plan-error" style="color:red" id="additional_tax_elite_plan"></span>
					                        </div>
					                    </div>
	                                </div>
	                                <div class="panel-footer">
	                                    <button class="btn btn-primary pull-right">Submit</button>
	                                </div>
	                                {!! csrf_field() !!}
	                            </form>                               
                            </div>  --}}
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@stop
@section('js')
	<script type="text/javascript" src="{!!asset('backend/js/plugins/fileinput/fileinput.min.js')!!}"></script>
	<script type="text/javascript">
		// Social links form
		$("#social-links-form").on("submit", function(){
            $.ajax({
                'url'      : "{!! URL('admin/configuration/social-links') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : $(this).serialize(),
                success    : function(data){
                	// Remove error
                	$(".form-group-social-links").removeClass("has-error");
                	$(".social-links-error").html("");
                    if(data.result == 'success'){
                    	swal("Good job!", "Social Links has been updated.", "success");
                    }
                    else{
                		swal("Action failed", "Please check your inputs or connection and try again.", "error");
						$.each(data.errors,function(key,value){
		                    if(value != ""){
		                        $("#"+key).text(value);
		                        $("#"+key).parent().parent().addClass("has-error");
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
		// Email form
		$("#email-form").on("submit", function(){
            $.ajax({
                'url'      : "{!! URL('admin/configuration/email') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : $(this).serialize(),
                success    : function(data){
                	// Remove error
                	$(".form-group-email").removeClass("has-error");
                	$(".email-error").html("");
                    if(data.result == 'success'){
                    	$(".email-input").val("");
                    	swal("Good job!", "Email has been updated.", "success");
                    }
                    else{
                		swal("Action failed", "Please check your inputs or connection and try again.", "error");
						$.each(data.errors,function(key,value){
		                    if(value != ""){
		                        $("#"+key).text(value);
		                        $("#"+key).parent().parent().addClass("has-error");
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
		// Password form
		$("#password-form").on("submit", function(){
            $.ajax({
                'url'      : "{!! URL('admin/configuration/password') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : $(this).serialize(),
                success    : function(data){
                	// Remove error
                	$(".form-group-password").removeClass("has-error");
                	$(".password-error").html("");
                    if(data.result == 'success'){
                    	$(".password-input").val("");
                    	swal("Good job!", "Password has been updated.", "success");
                    }
                    else{
                		swal("Action failed", "Please check your inputs or connection and try again.", "error");
						$.each(data.errors,function(key,value){
		                    if(value != ""){
		                        $("#"+key).text(value);
		                        $("#"+key).parent().parent().addClass("has-error");
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
		$("#other-charges-form").on("submit", function(){
            $.ajax({
                'url'      : "{!! URL('admin/configuration/other-charges') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : $(this).serialize(),
                success    : function(data){
                	// Remove the error
                	$(".form-group-other-charges").removeClass("has-error");
                	$(".other-charges-error").html("");
                    if(data.result == 'success'){
                    	swal("Good job!", "Other charges has been updated.", "success");
                    }
                    else{
                		swal("Action failed", "Please check your inputs or connection and try again.", "error");
						$.each(data.errors,function(key,value){
		                    if(value != ""){
		                        $("#"+key).text('The input is invalid.');
		                        $("#"+key).parent().parent().addClass("has-error");
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
		// API keys form
		$("#api-keys-form").on("submit", function(){
            $.ajax({
                'url'      : "{!! URL('admin/configuration/api-keys') !!}",
                'method'   : 'post',
                'dataType' : 'json',
                'data'     : $(this).serialize(),
                success    : function(data){
                	// Remove the error
                	$(".form-group-api-keys").removeClass("has-error");
                	$(".api-keys-error").html("");
                    if(data.result == 'success'){
                    	swal("Good job!", "API Keys has been updated.", "success");
                    }
                    else{
                		swal("Action failed", "Please check your inputs or connection and try again.", "error");
						$.each(data.errors,function(key,value){
		                    if(value != ""){
		                        $("#"+key).text(value);
		                        $("#"+key).parent().parent().addClass("has-error");
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
		// Numbers only
        $('.numbers_only').keypress(function(event){
            if((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
	</script>
@stop