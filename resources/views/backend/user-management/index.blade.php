@extends('backend.default')
@section('title','Users ~ YNetPla Admin')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="bgc-white bd bdrs-3 p-20 mB-20">
			<h4 class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">List of all YNetPla users</h4>
			<table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
				<tr>
					<th>Name</th>
					<th>Username</th>
					<th>Country Code</th>
					<th>Member Since</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				@forelse($users as $value)
				<tr>
					<td>{{ ucwords($value->full_name) }}</td>
					<td>{{ strtolower($value->username) }}</td>
					<td>{{ $value->country_code }}</td>
					<td>{{ Carbon\Carbon::parse($value->created_at)->format('Y/m/d') }}</td>
					<td><!-- Example split danger button -->
					<div class="btn-group">
						<button type="button" class="btn btn-secondary btn-sm" onclick="window.location='{{URL('admin/users/'.$value->username)}}'">View</button>
						<button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<a class="dropdown-item" href="#">Something else here</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Separated link</a>
						</div>
					</div>
				</td>
				</tr>
				@empty
				<p>Cannot find any users..</p>
				@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('js')
	<script type="text/javascript">
		$("body").delegate(".delete-data","click",function(e){
	        e.preventDefault();
	        var selector = $(this);
	        var location = selector.data("location");
			swal({
				title             : "Are you sure?",
				text              : "You are about to delete this plan!",
				type              : "warning",
				showCancelButton  : true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText : "Yes, delete it!",
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
	    });
	</script>
@stop