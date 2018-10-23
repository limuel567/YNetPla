@if(Session::has('success'))
	<div class="alert alert-success" role="alert">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		{!! Session::get('success') !!}
	</div>
@elseif(Session::has('info'))
	<div class="alert alert-info" role="alert">
	    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    {!! Session::get('info') !!}
	</div>
@elseif((Session::has('warning')))
	<div class="alert alert-warning" role="alert">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		{!! Session::get('warning') !!}
	</div>
@elseif((Session::has('danger')))
	<div class="alert alert-danger" role="alert">
    	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		{!! Session::get('danger') !!}
    </div>
@endif