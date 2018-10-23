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
                        <th>Type</th>
                        <th>Genre</th>
                        <th>Popularity</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($null as $key => $value)
                        <tr>
                        <th><span data-toggle="tooltip" title="<img src='{{unserialize($value['serialize'])['image']['medium']}}' />">{{ unserialize($value['serialize'])['name'] }}</span></th>
                        <td>{{ unserialize($value['serialize'])['type'] }}</td>
                        <td>{{ implode(", ",unserialize($value['serialize'])['genres']) }}</td>
                        <td>{{ $value['weight'] }}</td>
                        <td>{{ Carbon\Carbon::parse($value->updated_at)->format('Y/m/d h:m A') }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.location='{{URL('admin/trailer-management/edit/'.Crypt::encrypt($value->id))}}'">Edit</button>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
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
                        <th>Type</th>
                        <th>Genre</th>
                        <th>Popularity</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($not_null as $key => $value)
                        <tr>
                        <th><span data-toggle="tooltip" title="<img src='{{unserialize($value['serialize'])['image']['medium']}}' />">{{ unserialize($value['serialize'])['name'] }}</span></th>
                        <td>{{ unserialize($value['serialize'])['type'] }}</td>
                        <td>{{ implode(", ",unserialize($value['serialize'])['genres']) }}</td>
                        <td>{{ $value['weight'] }}</td>
                        <td>{{ Carbon\Carbon::parse($value->updated_at)->format('Y/m/d h:m A') }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.location='{{URL('admin/trailer-management/edit/'.Crypt::encrypt($value->id))}}'">Edit</button>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).ready( function () {
        $('.dataTable').DataTable();
        $('.dataTable2').DataTable();
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