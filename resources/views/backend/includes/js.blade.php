@if (Request::segment(2)=='tv-series-trailer')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>    
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-noty/2.4.1/jquery.noty.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-noty/2.4.1/layouts/bottomRight.min.js"></script> 
@else
<script type="text/javascript" src="{!!asset('backend/js/app.js')!!}"></script>
@endif
<script type="text/javascript" src="{!!asset('backend/js/jquery.ac-form-field-repeater.js')!!}"></script>
@yield('js')