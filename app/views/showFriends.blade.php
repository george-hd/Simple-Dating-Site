@extends('layouts.defaultLayout')

@section('show-friends')
    @if($friends->count() == 1)
        <h4>{{ 'You have '.$friends->count().' friend:' }}</h4>
    @elseif($friends->count() > 1)
        <h4>{{ 'You have '.$friends->count().' friends:' }}</h4>
    @endif
    @if($friends->count() >= 1)
        @foreach($friends as $friend)
            <div class="row messages">
                <div class="col-md-2">
                    <a href={{ 'user/'.$friend->user_id }}><img class="img100x100" src={{ $friend->avatar }}></a>
                </div>
                <div class="col-md-4 user-data">
                    <div>
                        {{ 'user name: '.ucfirst($friend->userName) }}
                    </div>
                    <div>
                        {{ 'first name: '.ucfirst($friend->firstName) }}
                    </div>
                    <div>
                        {{ 'last name: '.ucfirst($friend->lastName) }}
                    </div>
                    <div>
                        {{ 'email: '.$friend->email }}
                    </div>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-2">
                    {{ Form::open(array('url' => 'deleteFriend/'.$friend->user_id)) }}
                    {{ Form::submit('Delete user', array('class' => 'btn-danger')) }}
                    {{ Form::close() }}
                </div>
            </div>
        @endforeach
    @else
        <div class="error"> Yor friend list is empty!</div>
    @endif
@endsection