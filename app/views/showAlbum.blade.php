@extends('layouts.defaultLayout')

@section('show-album')
    @if($album->is_public == false)
        <div class="error">
            {{ 'private album:' }}
        </div>
        <h3>{{ $album->album_name }}</h3>
    @else
        <div class="success">
            {{ 'public album:' }}
        </div>
        <h3>{{ $album->album_name }}</h3>
    @endif
    <div class="row">
        <div class="col-md-6">
            <h4> Add a pic to {{ $album->album_name }}</h4>
            {{ Form::open(array('url' => '/picture', 'enctype' => 'multipart/form-data')) }}
            <div>
                <img class="img100x100" src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNO3AGaejwqJWq9NnsmMT1VjXy-sbs2ZpKBIZ5zXDrNNBCIP55ig'>
            </div>
            <div>
                {{ Form::file('uploadFile', array('name' => 'picture', 'class' => 'upload-file-input')) }}
            </div>
            @if($errors)
                <div class="error">
                    {{ $errors->first('picture') }}
                </div>
            @endif
            <div>
                {{ Form::hidden('album_id', $album->album_id) }}
                {{ Form::submit('Add picture', array('class' => 'btn btn-primary')) }}
            </div>
            {{ Form::close() }}
            <h4>Edit {{ $album->album_name }}</h4>
            {{ Form::open(array('url' => '/album/'.$album->album_id, 'method' => 'put', 'enctype' => 'multipart/form-data')) }}
                <div>
                    {{ Form::label('Album name') }}
                </div>
                <div>
                    {{ Form::text('album_name', $album->album_name) }}
                    @if($errors)
                        <span class="error"> {{ $errors->first('album_name') }} </span>
                    @endif
                </div>
                <div>
                    {{ Form::label('Type (public or private)') }}
                </div>
                <div>
                    {{ Form::select('is_public', array(1 => 'public', 0 => 'private')) }}
                </div>
                <div>
                    {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                </div>
            {{ Form::close() }}
            @if(Auth::user()->albums->contains($album))
                <div class="error">
                    {{ 'Warning: If delete the album you will loose all pic\'s in it !!!' }}
                </div>
                <div>
                    {{ Form::open(array('url' => 'album/'.$album->album_id, 'method' => 'delete')) }}
                    {{ Form::submit('delete album', array('class' => 'btn-danger')) }}
                    {{ Form::close() }}
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div>
                {{--<a href={{ URL::to('album') }}>Show all albums</a>--}}
            </div>
            @foreach($album->pictures as $pic)
                <div class="col-md-3">
                    <img class="img100x100" src={{ $pic->picture_link }}>
                    <div>
                        {{ $pic->picture_description }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection