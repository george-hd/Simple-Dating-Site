@extends('layouts.defaultLayout')

@section('albums')
    <div class="row">
        <div class="col-md-2">
            {{--<a href={{ URL::to('album/create') }}>Create new album</a>--}}
        </div>
        <div class="col-md-5">
        <h4> public albums</h4>
            @foreach($albums as $album)
                @if($album->is_public == 1)
                    <div>
                        <a href={{ 'album/'.$album->album_id }}>{{ $album->album_name }}</a>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-md-5">
        <h4> private albums</h4>
            @foreach($albums as $album)
                @if($album->is_public != 1)
                    <div>
                        <a href={{ 'album/'.$album->album_id }}>{{ $album->album_name }}</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection