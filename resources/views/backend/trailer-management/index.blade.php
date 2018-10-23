@extends('backend.default')
@section('title','Trailers ~ YNetPla Admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="p-20 initiate-tooltip">
                <h5 class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">Without Trailers</h5>
                <table class="dataTable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Genre</th>
                        <th>Popularity</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="p-20 initiate-tooltip">
                <h5 class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">With Trailers</h5>
                <table class="dataTable2 table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Genre</th>
                        <th>Popularity</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).ready( function () {
        $('.dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ URL('admin/tv-series-trailer/null') }}",
            "oLanguage": {
                "sProcessing": "<div class='col-md-12' style='position: fixed;z-index: 99;top: 0;left: 16px;height: 695px;padding: 0;padding-right: 30px;'><div style='height: 100%;width: 100%;background-image: url(https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif);background-repeat: no-repeat;background-position: center;background-color: white;'></div></div>"
            },
            "processing" : true,
            "columns":[
                { "data": "name" },
                { "data": "status" },
                { "data": "genre" },
                { "data": "weight" },
                { "data": "updated_at" },
                {
                    "data": "id",
                    render:function(data, type, row)
                    {
                    return "<button type='button' class='btn btn-secondary btn-sm' onclick='window.location=&quot;"+window.location.href+"/edit/"+data+"&quot;'>Edit</button>";
                    },
                    "targets": -1
                }
            ]
        });
        $('.dataTable2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ URL('admin/tv-series-trailer/not-null') }}",
            "oLanguage": {
                "sProcessing": "<div class='col-md-12' style='position: fixed;z-index: 99;top: 0;left: 16px;height: 695px;padding: 0;padding-right: 30px;'><div style='height: 100%;width: 100%;background-image: url(https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif);background-repeat: no-repeat;background-position: center;background-color: white;'></div></div>"
            },
            "processing" : true,
            "columns":[
                { "data": "name" },
                { "data": "status" },
                { "data": "genre" },
                { "data": "weight" },
                { "data": "updated_at" },
                {
                    "data": "id",
                    render:function(data, type, row)
                    {
                    return "<button type='button' class='btn btn-secondary btn-sm' onclick='window.location=&quot;"+window.location.href+"/edit/"+data+"&quot;'>Edit</button>";
                    },
                    "targets": -1
                }
            ]
        });

        $('span[data-toggle="tooltip"]').tooltip({
            placement: 'right',
            html: true
        });
        $(".initiate-tooltip").click( function() {
            $('span[data-toggle="tooltip"]').tooltip({
                placement: 'right',
                html: true
            });
        });
        $('input[type=search]', '.initiate-tooltip').each(function() {
            $(this).keypress( function() {
                $('span[data-toggle="tooltip"]').tooltip({
                    placement: 'right',
                    html: true
                });
            });
        });
    });
    
</script>
@stop