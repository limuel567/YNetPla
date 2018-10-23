<div class="repeater-children repeater-children-{!!$page_data->id!!} repeater-children-{!!$page_data->id.'-'.date('His', strtotime($page_data->created_at))!!}" data-key="{!!date('His', strtotime($page_data->created_at))!!}">
	@foreach(unserialize($page_data->repeater_fields) as $key => $value)
		@if($key == 0)
			<a class='btn btn-info btn-rounded remove-repeater' data-id="{!!$page_data->id!!}"><i class='fa fa-times'></i></a>
		@endif
		<?php $field_name = 'field_repeater_'.str_replace('-','',App\Models\Helper::seoUrl($value['field_name'])).'_'.$page_data->id; ?>
		<div class="form-group clearfix">
			<label class="col-md-6 col-xs-12 control-label">{!! $value['field_name'] !!}</label>
	        <div class="col-md-11 col-xs-12">
	        	@if($value['field_type'] == 'text')
					<input type="text" class="form-control" name="{!!$field_name!!}[]">
	        	@elseif($value['field_type'] == 'textarea')
					<textarea class="form-control" rows="5" name="{!!$field_name!!}[]"></textarea>
	        	@elseif($value['field_type'] == 'image')
					<input type="file" class="file-simple file-simple-default" accept="image/jpg,image/png,image/gif" name="{!!$field_name!!}[]">
	        	@elseif($value['field_type'] == 'file')
					<input type="file" class="file-simple file-simple-default" name="{!!$field_name!!}[]">
				@elseif($value['field_type'] == 'wysiwyg_full')
				<textarea class="form-control summernote" rows="5" name="{!!$field_name!!}[]"></textarea>
				@endif
			</div>
		</div>
	@endforeach
</div>

<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script> 
<script type="text/javascript" src="{!!asset('backend/js/custom_summernote.js')!!}"></script>
<script>
	$(document).ready(function() {
		$('.summernote').summernote();
		$('.note-popover').css('display', 'none');
		$( "i.note-icon-video" ).parent().css( "display", "none" );
		$( "i.note-icon-picture" ).parent().css( "display", "none" );
	});
</script>	