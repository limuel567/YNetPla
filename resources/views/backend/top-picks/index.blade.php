@extends('backend.default')
@section("title","Editor's Choice ~ YNetPla Admin")
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            {{-- <h4 class="c-grey-900 mB-20">Subscription Plan<button class="btn btn-primary fl-r" onclick="window.location='{{URL('admin/subscription/create')}}'"><i class="ti-wand"></i> Create Plan</button></h4> --}}
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
                    <div class="p-20">
                        <h5 class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">Editor's Choice</h5>
                        <table class="dataTable table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Name</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($top_picks as $key => $value)
                                <tr>
                                <th>{{ ucwords($value->name) }}</th>
                                <td>{{ Carbon\Carbon::parse($value->updated_at)->format('Y/m/d h:m A') }}</td>
                                <td>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="window.location='{{URL('admin/editor-choice/edit/'.Crypt::encrypt($value->id))}}'">Edit</button>
                                </td>
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