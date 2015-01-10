@extends('layouts.defaultLayout')

@section('chat')

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
{{ HTML::script('brainsocket/brain-socket.min.js') }}

<h3><img class="img25x25" src={{ User::find($chat->owner)->avatar }}> {{ ' Welcome to '.ucfirst($chat->chat_name).'\'s chat room' }}</h3>

<div class="container" id="vvv">
    <div class="row chat">
        <div class="col-md-2 chat-users" id="chat-users">
            @foreach($chat->users as $user)
                <div class="user-names">
                    <img class="img25x25" src={{ $user->avatar }}>{{ ' '.$user->userName }}
                    <button style="background-color: lightblue" class="webcam webcam-off" id={{ $user->user_id }}>cam</button>
                </div>
            @endforeach
        </div>
        <div class="col-md-10" id="my-cam">

        </div>
    </div>
    <div class="row">
        <div class="col-md-11">
            {{ Form::open(array('url' => '/chat/getChat/'.$chat->chat_id)) }}
            {{ Form::textarea('message', null, array('class' => 'send-chat-message-box', 'id' => 'chat-message')) }}
            {{ Form::hidden('chat_id', $chat->chat_id, array('id' => 'room_id')) }}
            {{ Form::hidden('user_id', Auth::user()->user_id, array('id' => 'user_id')) }}
            {{ Form::close() }}
        </div>
        <div class="col-md-1">
            <button class="send-message-btn" id="send-message-btn">Send message</button>
        </div>
    </div>
    <button id="id" class="btn btn-primary">close connection</button>
</div>
<script>



//    $('#cam').bind('contextmenu', function(e){
//        e.stopPropagation();
//        e.preventDefault();
//
//        if(e.button == 2){
//            console.log('right button clicked');
//        }
//    });
//
//    $('#cam').on('click', function(){
//        console.log('left button clicked');
//    })

    var chat = {{ $chat }}

    window.app = {};
    app.BrainSocket = new BrainSocket(
            new WebSocket('ws://http://churka/gopagoda.com:8080'),
            new BrainSocketPubSub()
    );

    var user = {{ Auth::user() }}

    app.BrainSocket.Event.listen('generic.event',function(msg){

        if(msg.client.data.userStartsBroadcasting){
            $('#'+msg.client.data.userStartsBroadcasting).addClass('webcam-on').removeClass('webcam-off');
        }

        if(user.user_id == msg.client.data.viewCam){
            z();
            f();
        }

        if(msg.client.data.SDP && (msg.client.data.chat_id == chat.chat_id)){
        //getMedia();
            var offer = msg.client.data.SDP;
            peerConnection.setRemoteDescription(new SessionDescription(offer), function() {
                // firefox createAnswer needs 2 arguments. (remoteDescription, gotDescription)
                peerConnection.createAnswer(function(answer) {
                    peerConnection.setLocalDescription(answer, function() {
                        // send the answer to the remote connection
                        app.BrainSocket.message('generic.event',{
                            'answer':answer,
                            'sender':msg.client.data.user
                        });

                    })
                },
                function (sessionDescription){
                    peerConnection.setLocalDescription(sessionDescription);
                })
            });

            peerConnection.onaddstream = gotRemoteStream;
        }

        else if(msg.client.data.ice){
            peerConnection.addIceCandidate(new RTCIceCandidate(msg.client.data.ice));
            console.log(msg.client.data.ice);
        }

        if(msg.client.data.answer){ // && (user.user_id != msg.client.data.sender.user_id )) {

            peerConnection.setRemoteDescription(new SessionDescription(msg.client.data.answer) ,function(){

            },
            function(err){
                console.log(err);
            });
        }

        if(msg.client.data.chat.chat_id == chat.chat_id){

            $.ajax({
                url: '../../index.php/chat/getChatInfo/{{ $chat->chat_id }}',
                type: "GET",
                success: function(response){
                    $('#chat-users').html('');
                        for(var us in response){
                        {{--<button style="background-color: lightblue" class="webcam webcam-off" id={{ $user->user_id }}>cam</button>--}}
                            $('#chat-users').append('<div class="user-names">' +
                            '<img class="img25x25" src='+response[us].avatar+">"+response[us].userName +
                            '<button style="background-color: lightblue" class="webcam webcam-on" id='+response[us].user_id+'>cam</button></div>');
                        }
                    $('.webcam').on('click', function(){
                        app.BrainSocket.message('generic.event',{
                                    'viewCam':this.id
                                }
                        );
                    });
                }
            });

            if(msg.client.data.user.user_id == user.user_id){
                $('#my-cam').append('<div class="user-names">'+'<img class="img25x25" src='+msg.client.data.user.avatar+'>'+' '+msg.client.data.user.userName+': '+msg.client.data.message+'</div>');
            }else{
                $('#my-cam').append('<div class="user-names">'+'<img class="img25x25" src='+msg.client.data.user.avatar+'>'+' '+msg.client.data.user.userName+': '+msg.client.data.message+'</div>');
            }
            $('#my-cam').animate({ scrollTop: 1000000 }, "slow");
            return false;
        }
    });

    $('#chat-message').keypress(function(event) {
        if(event.keyCode == 13){
            app.BrainSocket.message('generic.event',{
                    'message':$(this).val(),
                    'user':user,
                    'chat': chat
                }
            );
            $(this).val('');
        }
        return event.keyCode != 13; }
    );

    $('#send-message-btn').on('click', function(){
        app.BrainSocket.message('generic.event',{
                'message':$('#chat-message').val(),
                'user':user,
                'chat': chat
            }
        );
        $('#chat-message').val('');
    })

    window.onbeforeunload = function(e){
        $.ajax({
            url: '../../index.php/chat/exit/user/{{ Auth::user()->user_id }}',
            type: 'GET',
            success: function(){

           }
        });
        //return 'the text here will appear in the confirm box';
    };

    ///////////////////////////////



        var video = document.createElement('video');
        video.setAttribute('id', 'myVideo');
        video.setAttribute('class', 'video');
        video.setAttribute('autoplay', true);
        video.setAttribute('width', 200);
        video.setAttribute('height', 200);
        document.getElementById('vvv').appendChild(video);

        var videoo = document.createElement('video');
        videoo.setAttribute('id', 'remoteVideo');
        videoo.setAttribute('class', 'video');
        videoo.setAttribute('autoplay', true);
        videoo.setAttribute('width', 200);
        videoo.setAttribute('height', 200);
        document.getElementById('vvv').appendChild(videoo);

    $(function() {
        $( ".video").draggable();
    });

        var streamToAttach;

        var PeerConnection = window.mozRTCPeerConnection || window.webkitRTCPeerConnection || window.RTCPeerConnection;
        var IceCandidate = window.mozRTCIceCandidate || window.RTCIceCandidate;
        var SessionDescription = window.mozRTCSessionDescription || window.RTCSessionDescription;
        var RTCIceCandidate = window.mozRTCIceCandidate || window.RTCIceCandidate;

        navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

        var peerConnection = new PeerConnection(configuration);

        var configuration = {
            iceServers: [
                {"url": "stun:23.21.150.121"},
                {"url": "stun:stun.l.google.com:19302"},
                {"url": "stun:stun.services.mozilla.com"},
                {"url": "turn:numb.viagenie.ca", credential: "webrtcdemo", username: "louis%40mozilla.com"}
            ]
        };

        function gotRemoteStream(e){
        if(!e) return;
            document.getElementById('remoteVideo').src = URL.createObjectURL(e.stream);
            waitUntilRemoteStreamStartsFlowing();
        }

        function waitUntilRemoteStreamStartsFlowing()
        {
            if (!(remoteVideo.readyState <= HTMLMediaElement.HAVE_CURRENT_DATA
                || remoteVideo.paused || remoteVideo.currentTime <= 0))
            {
                // remote stream started flowing!
            }
            else setTimeout(waitUntilRemoteStreamStartsFlowing, 50);
        }
        function z() {
            if (navigator.getUserMedia) {
                navigator.getUserMedia(
                        {video: true, audio: true},
                        function (localMediaStream) {
                            var v = document.querySelector('video');
                            v.src = window.URL.createObjectURL(localMediaStream);
                            streamToAttach = localMediaStream;
                            peerConnection.addStream(localMediaStream);
                            app.BrainSocket.message('generic.event', {
                                        'userStartsBroadcasting': user.user_id
                                    }
                            );
                        },
                        function (err) {
                            console.log("The following error occured: " + err);
                        }
                );
            }
        }

        z();

        function f(){

            //peerConnection.addStream(streamToAttach);

            peerConnection.createOffer(function (sessionDescription){
                peerConnection.setLocalDescription(sessionDescription);
                app.BrainSocket.message('generic.event',{
                   'SDP':sessionDescription,
                   'sender': user,
                   'chat_id': chat.chat_id
                });
            }, function(err){ console.log(err); }, { mandatory: { "offerToReceiveAudio":true,"offerToReceiveVideo":true } });

            peerConnection.onicecandidate = function (e) {
                // candidate exists in e.candidate
                if (e.candidate == null) { return }
                //send("icecandidate", JSON.stringify(e.candidate));
                app.BrainSocket.message('generic.event',{
                   'ice':e.candidate
                });

            };
        }

    $('.webcam').on('click', function(){
        app.BrainSocket.message('generic.event',{
                'viewCam':this.id
            }
        );
    });
    
</script>

@endsection