@extends('backend.default')
@section('title','Content Management')
@section('css')
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="bgc-white bd bdrs-3 p-20 mB-20">
			<div class="row">
				<div class="col-md-6">
					<h4 class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">Content Management</h4>
				</div>
				{{-- <div class="col-md-6">
						<button type="button" class="btn btn-secondary btn-sm" style="float:right;" onclick="window.location='{!! url('admin/content-management/add') !!}'">Add Content</button>
				</div> --}}
			</div>
			<table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
				<tr>
					<th>Name</th>
					<th>Last Updated</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					@forelse($pages as $value)
					<tr>
						<td>{{ $value->name }} Page</td>
						<td>{{ Carbon\Carbon::parse($value->created_at)->format('Y/m/d h:m A') }}</td>
						<td><!-- Example split danger button -->
							<button type="button" class="btn btn-secondary btn-sm" onclick="window.location='{{URL('admin/content-management/edit-content/'.Crypt::encrypt($value->id))}}'">Edit</button>
							<button type="button" class="btn btn-secondary btn-danger btn-sm" onclick="window.location='{{URL('admin/content-management/edit-content/'.Crypt::encrypt($value->id))}}'">Delete</button>
						</td>
					</tr>
					@empty
					<p>No Content Data</p>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('js')
	<script type="text/javascript" src="{!!asset('backend/js/plugins/datatables/jquery.dataTables.min.js')!!}"></script>
	<script type="text/javascript">
	    if($(".datatable").length > 0){
	        $(".datatable").dataTable();
	        $(".datatable").on('page.dt',function(){
	            onresize(100);
	        });
	    }  
	</script>
@stop