@extends('layouts.defaultLayout')
@section('registration')
<div class="row">
    <div class="col-md-6">
    {{ Form::open(array('url' => '/user')) }}

        <div>
            {{ Form::label('username:') }}
        </div>
        <div>
            {{ Form::text('userName') }}
            <span class="error">
                @if($errors)
                    {{ $errors->first('userName') }}
                @endif
            </span>
        </div>
        <div>
            {{ Form::label('email:') }}
        </div>
        <div>
            {{ Form::email('email') }}
            <span class="error">
                @if($errors)
                    {{ $errors->first('email') }}
                @endif
            </span>
        </div>
        <div>
            {{ Form::label('password:') }}
        </div>
        <div>
            {{ Form::password('password') }}
            <span class="error">
                @if($errors)
                    {{ $errors->first('password') }}
                @endif
            </span>
        </div>
        <div>
            {{ Form::label('confirm password:') }}
        </div>
        <div>
            {{ Form::password('confirm') }}
            <span class="error">
                @if($errors)
                    {{ $errors->first('confirm') }}
                @endif
            </span>
        </div>
        <div>
            {{ Form::submit('Register', array('class' => 'btn btn-success')) }}
        </div>
    </div>
</div>

@endsection