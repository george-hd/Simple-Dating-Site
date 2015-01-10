@extends('layouts.defaultLayout')

@section('login-form')
    <div class="row">
        <div class="col-md-6">
            {{ Form::open(array('url' => 'login')) }}

                <div>
                    {{ Form::label('User:') }}
                </div>
                <div>
                    {{ Form::text('userName', Input::old('userName')) }}
                </div>
                <div>
                    {{ Form::label('Password:') }}
                </div>
                <div>
                    {{ Form::password('password') }}
                </div>
                @if(isset($error))
                    <div class="error">
                        {{ $error }}
                    </div>
                @endif
                <div>
                    {{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection