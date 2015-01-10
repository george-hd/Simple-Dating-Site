@extends('layouts.defaultLayout')

@section('show-messages')
    @foreach($messagesData as $msg)
        <div class="row messages">
            <div class="col-md-2">
                <a href={{ 'user/'.$msg->getSender()->user_id }}><img class="img100x100" src={{ $msg->getSender()->avatar }}></a>
            </div>
            <div class="col-md-3 user-data">
                <div>
                    {{ 'user: '.$msg->getSender()->userName }}
                </div>
                <div>
                    {{ 'email: '.$msg->getSender()->email }}
                </div>
                <div>
                    {{ 'first name: '.$msg->getSender()->firstName }}
                </div>
                <div>
                    {{ 'last name: '.$msg->getSender()->lastName  }}
                </div>
            </div>
            <div class="col-md-5 message-body">
                {{ $msg->getMessage()->message_body }}
            </div>
            <div class="col-md-2">
                <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                    <a href={{ 'message/'.$msg->getMessage()->message_id }}><button class="btn-info" type="button">read message</button></a>
                    {{ Form::open(array('url' => 'message/'.$msg->getMessage()->message_id, 'method' => 'delete')) }}
                    {{ Form::submit('delete message', array('class' => 'btn-danger')) }}
                    {{ Form::close() }}
                    {{--<a href="/WebSIte"><button class="btn-danger" type="button">delete message</button></a>--}}
                </div>
                {{--<div>--}}
                    {{--<a href="#"><button class="btn btn-warning">read message</button></a>--}}
                {{--</div>--}}
            </div>
        </div>
    @endforeach
@endsection