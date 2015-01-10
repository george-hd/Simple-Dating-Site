@extends('layouts.defaultLayout')

@section('show-message')
    <div class="row messages">
        <div class="col-md-2">
            <a href={{ URL::to('user', $messageViewModel->getSender()->user_id) }}><img class="img100x100" src={{ $messageViewModel->getSender()->avatar }}></a>
        </div>
        <div class="col-md-2 user-data">
            <div>
                {{ ucfirst($messageViewModel->getSender()->userName).' says:' }}
            </div>
        </div>
        <div class="col-md-6">
            {{ $messageViewModel->getMessage()->message_body }}
        </div>
        <div class="col-md-1">
            {{ Form::open(array('url' => 'message/'.$messageViewModel->getMessage()->message_id, 'method' => 'delete')) }}
            {{ Form::submit('delete message', array('class' => 'btn-danger')) }}
            {{ Form::close() }}
        </div>
    </div>
    <div class="row messages">
        <div class="col-md-2">
            <a href={{ 'user/'.$messageViewModel->getReceiver()->user_id }}><img class="img100x100" src={{ $messageViewModel->getReceiver()->avatar }}></a>
        </div>
        <div class="col-md-2 user-data">
            {{ 'Your answer:' }}
        </div>
        <div class="col-md-7">
            {{ Form::open(array('url' => '/message/sendMessage/'.$messageViewModel->getSender()->user_id)) }}
            <div>
                {{ Form::textarea('message_body', null, array('size' => '60x7', 'class' => 'send-message-box')) }}
                @if(isset($errors))
                    <div class="error"> {{ $errors->first('message_body') }} </div>
                @endif
            </div>
            <div>
                {{ Form::hidden('id', Auth::user()->user_id) }}
            </div>
            <div>
                {{ Form::submit('Send the answer', array('class' => 'btn btn-primary')) }}
            </div>
            @if(isset($flash))
                <div class="success">
                    {{ $flash }}
                </div>
            @endif
            {{ Form::close() }}
        </div>
    </div>
@endsection