@extends('layouts.defaultLayout')
@section('edit-profile')

{{--<a href={{ URL::to('album') }}><button class="btn btn-primary">view your albums</button></a>--}}
<h1>Change your data</h1>

<div class="row">

    <div class="col-md-4">
        <img class="img200x200" src={{ $user->avatar }}>
        {{ Form::open(array('url' => 'user/'.$user->user_id, 'files'=>true, 'method' => 'put', 'enctype' => 'multipart/form-data')) }}
        <div>
            {{ Form::file('uploadFile', array('name' => 'avatar', 'class' => 'upload-file-input')) }}
        </div>
        @if($errors)
            <div class="error">
                {{ $errors->first('avatar') }}
            </div>
        @endif
        <div>
            {{ Form::submit('Change avatar', array('class' => 'btn btn-primary')) }}
        </div>
        {{ Form::close() }}

    </div>
    <div class="col-md-4">
        {{ Form::open(array('url' => 'user/'.$user->user_id, 'method' => 'put')) }}
        <div>
            {{ Form::label('User name') }}
        </div>
        <div>
            {{ Form::text('userName', ucfirst($user->userName)) }}
            @if($errors)
                <span class="error">
                    {{ $errors->first('userName') }}
                </span>
            @endif
        </div>
        <div>
            {{ Form::label('First name') }}
        </div>
        <div>
            {{ Form::text('firstName', ucfirst($user->firstName)) }}
            @if($errors)
            <span class="errorr">
                    {{ $errors->first('firstName') }}
                </span>
            @endif
        </div>
        <div>
            {{ Form::label('Last name') }}
        </div>
        <div>
            {{ Form::text('lastName', ucfirst($user->lastName)) }}
            @if($errors)
            <span class="error">
                {{ $errors->first('lastName') }}
            </span>
            @endif
        </div>
        <div>
            {{ Form::label('email') }}
        </div>
        <div>
            {{ Form::text('email', $user->email) }}
            @if($errors)
            <span class="error">
                {{ $errors->first('email') }}
            </span>
            @endif
        </div>
        <div>
            {{ Form::submit('Change data', array('class' => 'btn btn-primary')) }}
        </div>
        {{ Form::close() }}
    </div>
    <div class="col-md-4">
        {{ Form::open(array('url' => 'user/'.$user->user_id, 'method' => 'put')) }}
        <div>
            {{ Form::label('old password') }}
        </div>
        <div>
            {{ Form::password('oldPassword') }}
            @if(isset($flash))
                <div class="error">
                    {{ $flash }}
                </div>
            @endif
        </div>
        <div>
            {{ Form::label('new password') }}
        </div>
        <div>
            {{ Form::password('password') }}
        </div>
        @if($errors)
            <div class="error">
                {{ $errors->first('password') }}
            </div>
        @endif
        <div>
            {{ Form::label('confirm new password') }}
        </div>
        <div>
            {{ Form::password('confirm') }}
        </div>
        @if($errors)
            <div class="error">
                {{ $errors->first('confirm') }}
            </div>
        @endif
        @if(isset($success))
            <div class="success">
                {{ $success }}
            </div>
        @endif
        <div>
            {{ Form::submit('Change password', array('class' => 'btn btn-danger')) }}
        </div>
        {{ Form::close() }}
        <div class="timestamps">
            {{ 'Updated: '.$user->updated_at }}
        </div>
        <div class="timestamps">
            {{ 'Created: '.$user->created_at }}
        </div>
    </div>
</div>

<div class="row">
    {{ Form::open(array('url' => 'user/'.$user->user_id, 'method' => 'delete')) }}
    {{ Form::submit('Delete account', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>

<script>
    $('.success').fadeOut(3000);
</script>
@endsection