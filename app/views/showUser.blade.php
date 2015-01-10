@extends('layouts.defaultLayout')

@section('show-user')
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <img class="img200x200" src={{ $user->avatar }}>
                </div>
                <div class="col-md-6">
                    <div class="btn-group-vertical col-md-7" role="group" aria-label="...">
                        {{ Form::open(array('url' => 'friends/'.$user->user_id)) }}
                        {{ Form::submit(' Send a friendship request', array('class' => 'btn-success', 'id' => 'friend-ship')) }}
                        {{ Form::close() }}
                        {{--{{ Form::open(array('url' => 'friends/'.$user->user_id)) }}--}}
                        {{--{{ Form::submit('friendship', array('class' => 'btn-info')) }}--}}
                        {{--{{ Form::close() }}--}}
                    </div>
                </div>
            </div>
            <div class="row user-data">
                <div>
                    {{ 'User name: '.$user->userName }}
                </div>
                <div>
                    {{ 'First name: '.$user->firstName }}
                </div>
                <div>
                    {{ 'Last name'.$user->lastName }}
                </div>
                <div>
                    {{ 'Email: '.$user->email }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {{ Form::open(array('url' => '/message/sendMessage/'.$user->user_id)) }}
            <div>
                {{ Form::label('send a message to '.$user->userName.':') }}
            </div>
            <div>
                {{ Form::textarea('message_body', null, array('size' => '60x7', 'class' => 'send-message-box')) }}
                @if(isset($errors))
                    <div class="error"> {{ $errors->first('message_body') }} </div>
                @endif
            </div>
            <div>
                {{ Form::hidden('id', $user->user_id) }}
            </div>
            <div>
                {{ Form::submit('Send message', array('class' => 'btn btn-primary')) }}
            </div>
            @if(isset($flash))
                <div class="success">
                    {{ $flash }}
                </div>
            @endif
            {{ Form::close() }}
        </div>
    </div>
    <div>
        @if(count($user->albums) > 0)
            <div class="col-md-6">
                <h4>Public albums:</h4>
                    @foreach($user->albums as $album)
                        @if($album->is_public == 1 && count($album->pictures) > 0)
                            <h5>{{ $album->album_name }}</h5>
                            <div>
                                <a href={{ URL::to('album', $album->album_id) }}> <img class="img100x100 album" src={{ $album->pictures[0]->picture_link }}></a>
                                {{ 'The album has '.$album->pictures->count().' pictures' }}
                            </div>
                            <ul>
                                <li style="color: saddlebrown">If you want to see an album just click on it. </li>
                                <li style="color: saddlebrown">Private albums are visible only for user's friends.</li>
                            </ul>
                        @elseif($album->is_public == 1 && count($album->pictures) == 0)
                            <h5>{{ $album->album_name }}</h5>
                            <div>
                                <img class="img100x100 album" src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQFeJYxm0VsMkxYNYSaWQpGG4GGSwmHoB2Hz0AwIKCEwv3CjyWV">
                                {{ 'The album has '.$album->pictures->count().' pictures' }}
                            </div>
                        @endif
                    @endforeach
            </div>
            <div class="col-md-6">
                <h4>Private albums:</h4>
                @foreach($user->albums as $album)
                    @if($album->is_public != 1 && Auth::user()->user_id == $user->user_id)
                        <h5>{{ $album->album_name }}</h5>
                        <a href={{ URL::to('album', $album->album_id) }}> <img class="img100x100 album" src={{$album->pictures[0]->picture_link }}></a>
                        {{ 'The album has '.$album->pictures->count().' pictures' }}
                    @elseif($album->is_public != 1 && User::getFriends()->contains($user))
                        <h5>{{ $album->album_name }}</h5>
                        <a href={{ URL::to('album', $album->album_id) }}> <img class="img100x100 album" src={{$album->pictures[0]->picture_link }}></a>
                        {{ 'The album has '.$album->pictures->count().' pictures' }}
                    @elseif($album->is_public != 1 && !User::getFriends()->contains($user))
                        <h5>{{ $album->album_name }}</h5>
                        <img class="img100x100 album" src="../../images/default_avatar.jpg">
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    {{--<canvas id="canvas" width="1000" height="300"></canvas>--}}
    {{--<button id="btn">ajax</button>--}}

    {{--<script>--}}
    {{--var btn = document.getElementById('btn');--}}

    {{--var canvas = document.getElementById('canvas');--}}
    {{--var ctx = canvas.getContext('2d');--}}
    {{--ctx.font = "30px Arial";--}}
    {{--btn.addEventListener('click', function(){--}}
            {{--$.ajax({--}}
                    {{--url: '/WebSite/public/index.php/user/9',--}}
                    {{--success: function(result){--}}
                        {{--ctx.fillText(result,50,50);--}}
                    {{--}--}}
                {{--});--}}
        {{--});--}}
    {{--ctx.fillText({{$user->userName}},10,10);--}}
    {{--</script>--}}
@endsection