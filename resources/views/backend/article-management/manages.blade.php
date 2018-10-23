@extends('backend.default')
@section('title','Create Challenge ~ Zuslo Admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">This is where you can {!! $label == 'Add' ? 'create' : 'update' !!} a challenge</h3>
                                <ul class="panel-controls">
                                    <li data-toggle="tooltip" data-placement="left" title="Back">
                                        <a href="{!! URL('admin/challenges') !!}"><span class="fa fa-backward"></span></a>
                                    </li>
                                </ul>                             
                            </div>
                            <form action="{!! URL('admin/challenges/save') !!}" method="post" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div class="form-group {!!$errors->first('image') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Cover Image</label>
                                        <div class="col-md-10 col-xs-12"> 
                                        <input type="file" class="file-simple file-logo" data-file="file-logo" data-value="{!! $label == 'Edit' ? asset('uploads/challenges/'.$challenge->image) : '' !!}" name="image" accept="image/*">
                                            <span class="help-block" style="color:red">{!!$errors->first('image')!!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group {!!$errors->first('name') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Name</label>
                                        <div class="col-md-10 col-xs-12">
                                            <input type="text" class="form-control" name="name" autocomplete="off" value="@if(old('name')){!! htmlentities(old('name')) !!}@elseif($label == 'Edit'){!!htmlentities($challenge->name)!!}@endif">
                                            <span class="help-block" style="color:red">{!!$errors->first('name')!!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group {!!$errors->first('contest_type') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Contest Type</label>
                                        <div class="col-md-10 col-xs-12">
                                            <select name="contest_type" id="multiple_categories" class="select2"> 
                                                <option value="0" @if($label == 'Edit') @if($challenge->contest_type == 0) selected @endif @endif>Regular</option>
                                                <option value="1" @if($label == 'Edit') @if($challenge->contest_type == 1) selected @endif @endif>Paid</option>
                                            </select>
                                            <span class="help-block" style="color:red">{!!$errors->first('contest_type')!!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group {!!$errors->first('creative_brief') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Creative Brief</label>
                                        <div class="col-md-10 col-xs-12" style="padding-bottom: 5px;">
                                            <textarea class="form-control summernote_simple" rows="4" name="creative_brief">@if($label == 'Edit'){!!htmlentities($challenge->creative_brief)!!}@endif</textarea>
                                        </div>
                                        <span class="help-block" style="color:red">{!!$errors->first('creative_brief')!!}</span>
                                    </div>
                                    <div class="form-group {!!$errors->first('reward') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Reward</label>
                                        <div class="col-md-10 col-xs-12">
                                            <input type="text" class="form-control" name="reward" autocomplete="off" value="@if(old('reward')){!! htmlentities(old('reward')) !!}@elseif($label == 'Edit'){!!htmlentities($challenge->reward)!!}@endif">
                                            <span class="help-block" style="color:red">{!!$errors->first('reward')!!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group {!!$errors->first('daterange') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Start Date - End Date</label>
                                        <div class="col-md-10 col-xs-12">
                                        <input type="text" name="daterange" class="form-control" value="@if(old('daterange')){!! htmlentities(old('reward')) !!}@elseif($label == 'Edit'){!! Carbon\Carbon::parse($challenge->starts_at)->format('M d h:m A') . ' - ' . Carbon\Carbon::parse($challenge->ends_at)->format('M d h:m A') !!}@endif" autocomplete="off">
                                            {{--  <i class="fa fa-calendar" aria-hidden="true"></i>  --}}
                                            <span class="help-block" style="color:red">{!!$errors->first('daterange')!!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group {!!$errors->first('days_to_enter') ? 'has-error' : ''!!}">
                                        <label class="col-md-2 col-xs-12 control-label">Days to Enter</label>
                                        <div class="col-md-2 col-xs-12 ">
                                            <input type="number" name="days_to_enter" class="form-control" min="2" value="2" autocomplete="off" onkeydown="return false">
                                            {{--  <i class="fa fa-calendar" aria-hidden="true"></i>  --}}
                                            <span class="help-block" style="color:red">{!!$errors->first('days_to_enter')!!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary pull-right">Save</button>
                                </div>
                                @if($label == 'Edit')
                                    <input type="hidden" name="id" value="{!! Crypt::encrypt($challenge->id) !!}">
                                @endif
                                {!! csrf_field() !!}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@stop
@section('js')
    <script type="text/javascript" src="{!!asset('backend/js/plugins/summernote/summernote.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('backend/js/custom_summernote.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('backend/js/plugins/fileinput/fileinput.min.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('js/select2.min.js')!!}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $(".select2").select2();
        $(function() {
            var d = new Date();

            var month = d.getMonth()+1;
            var day = d.getDate();

            var output = d.getFullYear() + '/' +
                ((''+month).length<2 ? '0' : '') + month + '/' +
                ((''+day).length<2 ? '0' : '') + day;

            $('input[name="daterange"]').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                autoUpdateInput: false,
                minDate: output,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'MMMM DD h:mm A'
                }
            });
            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MMMM DD h:mm A') + ' - ' + picker.endDate.format('MMMM DD h:mm A'));
                $('.date-hidden"').val(1);
            });
            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('.date-hidden"').val('');
            });
        });
        // File input display
		if($(".file-simple").length > 0){
			// This is for the existing fields
			$('.file-simple').each(function(){
				var file = "<img src='"+$(this).data('value')+"' class='file-preview-image' style='width:100%'>"
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
		}
        // Numbers only
        $('.numbers_only').keypress(function(event){
            if((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    </script>
@stop