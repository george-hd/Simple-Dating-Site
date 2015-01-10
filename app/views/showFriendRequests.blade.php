@extends('layouts.defaultLayout')

@section('show_friendship_requests')
    @if(count(User::getAllFriendRequests()) > 0)
    <h4>Users wants to be your friends:</h4>
    @foreach(User::getAllFriendRequests() as $request)
        <div class="row messages">
            <div class="col-md-2">
                <a href={{ URL::to('user', $request->user_id) }}><img class="img100x100" src={{ $request->avatar }}></a>
            </div>
            <div class=".messages-user-data col-md-4">
                <div>
                    {{ $request->userName }}
                </div>
                <div>
                    {{ $request->firstName }}
                </div>
                <div>
                    {{ $request->lastName }}
                </div>
                <div>
                    {{ $request->email }}
                </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-2 btn-group-vertical" role="group" aria-label="group_buttons">
                {{ Form::open(array('url' => 'acceptFriendship/'.$request->user_id)) }}
                    {{ Form::submit('Accept', array('class' => 'btn-warning')) }}
                {{ Form::close() }}
                {{ Form::open(array('url' => 'acceptFriendship/'.$request->user_id)) }}
                    {{ Form::submit('Reject', array('class' => 'btn-danger')) }}
                {{ Form::close() }}
            </div>
        </div>
    @endforeach
    @endif
@endsection