@extends('layouts.defaultLayout')

@section('all-public-chats')
    <h1> public chats </h1>
    <div class="row">
        <div class="col-md-6">
            <div>
                @foreach($chats as $chat)
                    <div class="row">
                        <a href={{ URL::to('chat/joinChat', $chat->chat_id) }}><div class="col-md-4"> <img class="img100x100 album" src={{ User::find($chat->owner)->avatar }}></div><div class="col-md 8"> <div>{{ '  '.$chat->chat_name.'\'s chat room' }}</div><div>{{ 'visitors: '.$chat->users->count() }}</div></div></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection