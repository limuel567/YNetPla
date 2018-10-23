@extends('backend.default')
@section('title','Edit '.$page_data->self_data->name.' Page')
@section('content')
<div class="row gap-20 masonry pos-r" style="overflow: initial!important;height: 1000px!important">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <div class="bgc-white p-20 bd">
            <form class="form-horizontal" method="post" action="{!! URL('admin/content-management/save') !!}" enctype="multipart/form-data">
                <h4 class="c-grey-900">{{$page_data->self_data->name}} Page Content </h4>
            <div class="mT-10">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach($page_data->page_section as $key => $value)
                        <li class="nav-item"><a class="nav-link {!! $key == 0 ? 'active' : '' !!}" data-toggle="tab" href="#tab-{!! $value->name !!}" role="tab" aria-controls="{!! $value->name !!}" aria-selected="true">{!! $value->name !!}</a></li>
                    @endforeach
                </ul>
                <div class="panel-body tab-content">
                        <?php $section_array    = []; ?>
                        <?php $section_distinct = 0; ?>
                        <?php $section_count    = count($page_data->page_content)-1; ?>
                        <?php $section_name     = ''; ?>
                        @foreach($page_data->page_content as $key => $value)
                            @if(!in_array($value->name, $section_array))
                                <?php $section_array[] = $value->name; ?>
                                @if($section_name != $value->name && $section_name != '' || $section_count == $key)
                                    </div>
                                @else
                                    <?php $section_count++; ?>
                                @endif
                                <div class="mT-20 tab-pane {!! $key == 0 ? 'active' : '' !!}" id="tab-{!! $value->name !!}">
                            @else
                                <?php $section_name = $value->name; ?>
                            @endif
                            @if($value->field_type == 'text')
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-12 control-label">{!! $value->field_name !!}</label>
                                    <div class="col-md-11 col-xs-12"> 
                                        <input type="text" class="form-control" value="{!! htmlentities($value->content) !!}" name="field_{!!$value->id!!}">
                                    </div>
                                </div>
                            @elseif($value->field_type == 'textarea')
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-12 control-label">{!! $value->field_name !!}</label>
                                    <div class="col-md-11 col-xs-12"> 
                                        <textarea class="form-control" rows="5" name="field_{!!$value->id!!}">{!! $value->content !!}</textarea>
                                    </div>
                                </div>
                            @elseif($value->field_type == 'image')
                                <div class="form-group">
                                    <label class="col-md-1 col-xs-12 control-label">{!! $value->field_name !!}</label>
                                    <div class="col-md-11 col-xs-12"> 
                                        <input type="file" class="file-simple file_{!!$value->id!!}" data-file='file_{!!$value->id!!}' accept="image/jpg,image/png,image/gif" name="field_{!!$value->id!!}" data-value="{!! $value->content !!}">
                                    </div>
                                </div>
                            @elseif($value->field_type == 'file')
                                <div class="form-group">
                                    <label class="col-md-1 col-xs-12 control-label">{!! $value->field_name !!}</label>
                                    <div class="col-md-11 col-xs-12"> 
                                        <input type="file" class="file-simple file_{!!$value->id!!}" data-file='file_{!!$value->id!!}' name="field_{!!$value->id!!}" data-value="{!! $value->content !!}">
                                    </div>
                                </div>
                            @elseif($value->field_type == 'wysiwyg_basic')
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-12 control-label">{!! $value->field_name !!}</label>
                                    <div class="col-md-11 col-xs-12"> 
                                        <textarea class="form-control summernote_simple" rows="5" name="field_{!!$value->id!!}">{!! $value->content !!}</textarea>
                                    </div>
                                </div>
                            @elseif($value->field_type == 'wysiwyg_full')
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-12 control-label">{!! $value->field_name !!}</label>
                                    <div class="col-md-11 col-xs-12">
                                        <textarea class="form-control summernote" rows="5" name="field_{!!$value->id!!}">{!! $value->content !!}</textarea>
                                    </div>
                                </div>
                            @elseif($value->field_type == 'repeater')
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="cms-title" style="min-width: 50%;">                                                
                                                <h3 class="panel-title">{!! $value->field_name !!}</h3>
                                                <ul class="panel-controls">
                                                        <li class="" data-toggle="tooltip" data-placement="left" title="Add" style="cursor:pointer">
                                                            <a class="cms-add-btn add-repeater-field" data-json='{!!base64_encode(serialize($value))!!}'><span class="fa fa-plus"></span></a>
                                                        </li>
                                                    </ul>
                                            </div>
                                                
                                        </div>                                        
                                    </div>
                                    <div class="panel-body">
                                        <div class="row content-holder repeater_display_{!!$value->id!!}">
                                            @if($value->content != '')
                                                @foreach(unserialize(base64_decode($value->content)) as $k => $v)
                                                    <div class="repeater-children repeater-children-{!!$value->id!!} repeater-children-{!!$value->id.'-'.$k!!}" data-key="{!!$k!!}" data-check='old'>
                                                        @foreach($v as $vk => $mv)
                                                        @if($vk == 0)
                                                        <div class="top-head">
                                                            <a class='btn btn-info btn-rounded remove-repeater' data-id="{!!$value->id!!}"><i class='fa fa-times'></i></a>
                                                        </div>
                                                        @endif
                                                            <?php $field_name = 'field_repeater_'.str_replace('-','',App\Models\Helper::seoUrl($mv['field_name'])).'_'.$value->id; ?>
                                                            <div class="form-group clearfix">
                                                                <label class="col-md-2 col-xs-12 control-label">{!! $mv['field_name'] !!}</label>
                                                                <div class="col-md-11 col-xs-10">
                                                                    @if($mv['field_type'] == 'text')
                                                                        <input type="text" class="form-control" name="{!!$field_name!!}[]" value="{!! htmlentities($mv['field_value']) !!}">
                                                                    @elseif($mv['field_type'] == 'textarea')
                                                                        <textarea class="form-control" rows="5" name="{!!$field_name!!}[]">{!! $mv['field_value'] !!}</textarea>
                                                                    @elseif($mv['field_type'] == 'image')
                                                                        @if($mv['field_name'] != '')
                                                                         <input type="file" class="file-simple file_{!!$field_name.$k!!}" data-file='file_{!!$field_name.$k!!}' accept="image/jpg,image/png,image/gif" name="{!!$field_name!!}[]" data-value="{!! $mv['field_value'] !!}">

                                                                        @else
                                                                            <input type="file" class="file-simple file_{!!$field_name.$k!!}" data-file='file_{!!$field_name.$k!!}' accept="image/jpg,image/png,image/gif" name="{!!$field_name!!}[]" data-value="uploads/others/no_image.jpg">
                                                                        @endif
                                                                    @elseif($mv['field_type'] == 'file')
                                                                        @if($mv['field_name'] != '')
                                                                            <input type="file" class="file-simple file_{!!$field_name.$k!!}" data-file='file_{!!$field_name.$k!!}' name="{!!$field_name!!}[]" data-value="{!! $mv['field_value'] !!}">
                                                                        @else
                                                                            <input type="file" class="file-simple file_{!!$field_name.$k!!}" data-file='file_{!!$field_name.$k!!}' name="{!!$field_name!!}[]" data-value="uploads/others/no_image.jpg">
                                                                        @endif
                                                                        @elseif($mv['field_type'] == 'wysiwyg_full')
                                                                        <textarea class="form-control summernote" rows="5" name="{!!$field_name!!}[]">{!! $mv['field_value'] !!}</textarea>
                                                                    @endif
                                                                </div>
                                                                
                                                                </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            @endif
                                            <input type="hidden" name="repeater_total_{!!$value->id!!}" value="@if($value->content != '') {!! count(unserialize(base64_decode($value->content))) !!} @else 0 @endif">
                                            <h5 class="note_{!!$value->id!!}" style="{!! $value->content != '' ? 'display:none;' : '' !!}"><i>Nothing to display, click the button on the upper right to add a content.</i></h1>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach                        
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" value="{!! $page_data->self_data->id !!}" name="id">
                        <button class="btn btn-primary pull-right">Save</button>
                        {!!csrf_field()!!}
                    </div>
            </div>
        </form>
    </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" integrity="sha256-tW5LzEC7QjhG0CiAvxlseMTs2qJS7u3DRPauDjFJ3zo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>

<script>
    $('footer').remove();
    $.uploadPreview({
        input_field: "#image-upload-0",   // Default: .image-upload
        preview_box: "#image-preview-0",  // Default: .image-preview
        label_field: "#image-label-0",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-1",   // Default: .image-upload
        preview_box: "#image-preview-1",  // Default: .image-preview
        label_field: "#image-label-1",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-2",   // Default: .image-upload
        preview_box: "#image-preview-2",  // Default: .image-preview
        label_field: "#image-label-2",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-3",   // Default: .image-upload
        preview_box: "#image-preview-3",  // Default: .image-preview
        label_field: "#image-label-3",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-4",   // Default: .image-upload
        preview_box: "#image-preview-4",  // Default: .image-preview
        label_field: "#image-label-4",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-5",   // Default: .image-upload
        preview_box: "#image-preview-5",  // Default: .image-preview
        label_field: "#image-label-5",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-6",   // Default: .image-upload
        preview_box: "#image-preview-6",  // Default: .image-preview
        label_field: "#image-label-6",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-7",   // Default: .image-upload
        preview_box: "#image-preview-7",  // Default: .image-preview
        label_field: "#image-label-7",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-8",   // Default: .image-upload
        preview_box: "#image-preview-8",  // Default: .image-preview
        label_field: "#image-label-8",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-9",   // Default: .image-upload
        preview_box: "#image-preview-9",  // Default: .image-preview
        label_field: "#image-label-9",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-10",   // Default: .image-upload
        preview_box: "#image-preview-10",  // Default: .image-preview
        label_field: "#image-label-10",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.uploadPreview({
        input_field: "#image-upload-11",   // Default: .image-upload
        preview_box: "#image-preview-11",  // Default: .image-preview
        label_field: "#image-label-11",    // Default: .image-label
        label_default: "Choose Image",   // Default: Choose File
        label_selected: "Replace Image",  // Default: Change File
        no_label: false                 // Default: false
    });
    $.trumbowyg.svgPath = $('textarea').data('svg-path');;
    $('textarea').trumbowyg();
</script>
<script type="text/javascript">
    // File input display
    if($(".file-simple").length > 0){
        // This is for the new added fields
        $(".file-simple-default").fileinput({
                showUpload  : false,
                showCaption : false,
                browseClass : "btn btn-info",
                showRemove  : false,
                showClose   : false,
                initialPreview: [

                                ],
                initialPreviewConfig: 	[{
                                            width: 'auto',
                                            height: 'auto'
                                        }],
                allowedFileTypes     : ["image"],
                allowedFileExtensions: ["jpg", "png", "gif"],
                previewconfiguration :  {
                                            previewAsData: false,
                                            image: 	{
                                                        width: "auto",
                                                        height: 'auto'
                                                    }
                                        }
        });
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
                                                width: 'auto',
                                                height: 'auto'
                                            }],
                    allowedFileTypes     : ["image"],
                    allowedFileExtensions: ["jpg", "png", "gif"],
                    previewconfiguration :  {
                                                previewAsData: false,
                                                image: 	{
                                                            width: "auto",
                                                               height: 'auto'
                                                        }
                                            }
            });
        });
    }
    // Add another repeater field
    $(document).on("click",".add-repeater-field",function(){
        $.ajax({
            'url'      : "{!! URL('admin/content-management/repeater-fields') !!}",
            'method'   : 'get',
            'dataType' : 'json',
            'data'     : { json : $(this).data('json') },
            success    : function(response){
                if(response.result == 'success'){
                    // Add the content
                    $(".repeater_display_"+response.id).append(response.content);
                    $(".note_"+response.id).css('display', 'none');
                    var total = $("input[name='repeater_total_"+response.id+"'").val();
                    $("input[name='repeater_total_"+response.id+"'").val(parseInt(total)+1);
                }
                else{
                    swal("Action failed", "Please check your inputs or connection and try again.", "error");
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
    // Remove repeater field
    $(document).on("click",".remove-repeater",function(){
        key   = $(this).parents('.repeater-children').data('key');
        check = $(this).parents('.repeater-children').data('check');
        // Remove the main children
        $($(this).parents('.repeater-children-'+$(this).data('id')+'-'+key)).remove();
        // Count all the children and remove if match
        if($('.repeater-children-'+$(this).data('id')).length == 0){
            $(".note_"+$(this).data('id')).removeClass('hide');
        }
        
            $('.summernote').summernote();
            $('.note-popover').css('display', 'none');
            $( "i.note-icon-video" ).parent().css( "display", "none" );
            $( "i.note-icon-picture" ).parent().css( "display", "none" );
        
        var total = $("input[name='repeater_total_"+$(this).data('id')+"'").val();
        $("input[name='repeater_total_"+$(this).data('id')+"'").val(parseInt(total)-1);
        if (check == 'old') {
            // Remove from the database
            $.ajax({
                'url'      : "{!! URL('admin/content-management/remove-repeater-fields') !!}",
                'method'   : 'get',
                'dataType' : 'json',
                'data'     : { key : key, id : $(this).data('id') },
                success    : function(response){
                    if(response.result == 'success'){
                        location.reload();
                    }
                    else{
                        swal("Action failed", "Please check your inputs or connection and try again.", "error");
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
        }
    });
    // Remove close button
    $(".fileinput-remove").remove();
</script>
@stop