@extends('backend.default')
@section('title',$label == 'Edit' ? "Edit Editor's Choice ~ YNetPla Admin" : "Create Editor's Choice ~ YNetPla Admin")
@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-8 offset-md-2">
        <div class="bgc-white p-20 bd">
            <h4 class="c-grey-900">Add Movie Trailer's</h4>
            <div class="mT-30">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <form action="">
                            <label for="keywords">Search:</label>
                        <input type="text" name="keywords" class="form-control" placeholder="" value="{{isset($keywords) ? $keywords : ''}}">
                            <div class="invalid-feedback" id="keywords"></div>
                        </form>
                    </div>
                    <div class="form-group col-md-6"></div>
                    @foreach ($search as $item)
                    <div title="{{$item->getTitle()}}" class="form-group col-md-3 pick">
                        <a href="{!! 'movies-trailer/edit/'.Crypt::encrypt($item->getId()) !!}" style="color: #72777a;">
                            <label class="pick-title">{{strlen($item->getTitle()) > 20 ? str_limit($item->getTitle(), 20) : $item->getTitle()}}</label>
                            <img class="pick-img" src="{!!$item->getPosterImage() == '' ? $avatar->avatar : '//image.tmdb.org/t/p/w342'.$item->getPosterImage() !!}" alt="" style="border: 1px solid #000000; width:100%; max-height:260px;">
                            <label class="pick-year">{{substr(get_object_vars($item->getReleaseDate())['date'], 0,4)}}</label>
                            <input type="hidden" id="top-picked" value="{{Crypt::encrypt($item->getId())}}" class="form-control">
                        </a>
                    </div>
                    @endforeach
                    <div class="row" style="width:100%;margin:0 auto;justify-content:center;">
                        <div>
                            {!! $search->appends(Input::except('page'))->render() !!}
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
</script>
@stop