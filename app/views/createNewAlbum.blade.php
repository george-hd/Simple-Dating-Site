@extends('layouts.defaultLayout')

@section('createNewAlbum')
    <div class="row">
        <div class="col-md-7">
            <h1>Create new album</h1>
            {{ Form::open(array('url' => '/album')) }}
            <div>
                {{ Form::label('album name') }}
            </div>
            <div>
                {{ Form::text('album_name') }}
                @if(isset($errors))
                    <span class="error"> {{ $errors->first('album_name') }} </span>
                @endif
            </div>
            {{--<div>--}}
                {{--{{ Form::select('albums', array(1 => 'public', 0 => 'private'), 'public') }}--}}
            {{--</div>--}}
            <div>
                {{ Form::submit('Create album', array('class' => 'btn btn-primary')) }}
            </div>
            {{ Form::close() }}
        </div>
        <div class="col-md-7">
            <a href={{ URL::to('album') }}>Show all albums</a>
        </div>
    </div>
@endsection