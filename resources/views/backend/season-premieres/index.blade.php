@extends('backend.default')
@section("title","Season Premieres ~ YNetPla Admin")
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <button style="margin-left:20px;background-color: #666e75;border-color: #808991;" class="btn btn-primary fl-r" onclick="window.location='{{URL('admin/season-premiere/edit')}}'"><i class="ti-wand"></i> Edit Premieres</button><button class="btn btn-primary fl-r" onclick="window.location='{{URL('admin/season-premiere/add')}}'"><i class="ti-wand"></i> Add Shows</button>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
                    <div class="p-20">
                        <h5 class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">Season Premiere</h5>
                        <table class="dataTable table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Genre</th>
                                <th>Popularity</th>
                                <th>Premiere Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($season_premieres as $key => $value)
                                <?php $premiered_date = $value->premiere_date; $value = json_decode($value->encoded_json, TRUE);?>
                                <tr>
                                <th>{{ ucwords($value['name']) }}</th>
                                <td>{{ $value['type'] }}</td>
                                <td>{{ implode(", ", $value['genres']) }}</td>
                                <td>{{ $value['weight'] }}</td>
                                <td>{{ $premiered_date }}</td>
                                
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>>
            </div>
        </div>
    </div>
</div>
@stop