<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>WebSite</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css">
    {{ HTML::style('custom.css') }}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container default-container">
        <header>
            <nav class="navbar navbar-inverse" role="navigation">

                @if(!Auth::check())
                    <ul class="nav navbar-nav">

                        <li><a class="nav-a" href={{ URL::to('user') }}>Home</a></li>
                        <li><a class="nav-a" href={{ URL::to('user') }}>Friends</a></li>
                        <li><a class="nav-a" href={{ URL::to('user') }}>Profile</a></li>
                        <li><a class="nav-a" href={{ URL::to('user') }}>Users</a></li>
                        {{--<li><a class="nav-a" href={{ URL::to('user') }}>Public chat rooms</a></li>--}}
                        <li><a class="nav-a" href={{ URL::to('user') }}>Chat</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li><a class="nav-a" href={{ URL::to('register') }}>Register</a></li>
                        <li><a class="nav-a" href={{ URL::to('user') }}>Login</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav">
                        <li><a class="nav-a" href={{ URL::to('/') }}>Home</a></li>
                            <li role="presentation" class="dropdown" id="menu-drop-down">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                    Profile <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" id="ul-drop-down" role="menu">
                                    <li><a href={{ URL::to("user", array(Auth::user()->user_id, "edit")) }}>Edit user data</a></li>
                                    <li class="divider"></li>
                                    <li><a href={{ URL::to("showFriends") }}>Friends</a></li>
                                    <li class="divider"></li>
                                    <li><a href={{ URL::to('album') }}>View your albums</a></li>
                                    <li class="divider"></li>
                                    <li><a href={{ URL::to('album/create') }}>Create album</a></li>
                                </ul>
                            </li>
                        <li><a class="nav-a" href={{ URL::to("showUsers") }}>Users</a></li>
                        <li><a class="nav-a" href="javascript:goToChat()">Chat</a></li>
                            {{--<li role="presentation" class="dropdown" id="menu-drop-down">--}}
                                {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">--}}
                                    {{--Chat <span class="caret"></span>--}}
                                {{--</a>--}}
                                {{--<ul class="dropdown-menu" id="ul-drop-down" role="menu">--}}
                                    {{--<li><a href="http://localhost:3000">Create chat room</a></li>--}}
                                    {{--<li><a href={{ URL::to("chat/createChat") }}>Create chat room</a></li>--}}
                                    {{--<li class="divider"></li>--}}
                                    {{--<li><a href={{ URL::to("chat/getAllPublicChats") }}>Public chat rooms</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        @if(Message::countOfUnreadMessages() == 1)
                            <li><a class="nav-a" href={{ URL::to("message") }}>{{ 'you have '.Message::countOfUnreadMessages().' new message' }}</a></li>
                        @elseif(Message::countOfUnreadMessages() > 1)
                            <li><a class="nav-a" href={{ URL::to("message") }}>{{ 'you have '.Message::countOfUnreadMessages().' new messages' }}</a></li>
                        @else
                            <li><a class="nav-a" href={{ URL::to("message") }}>Messages</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="nav-a" href={{ URL::to("user", array(Auth::user()->user_id, "edit")) }}>{{ 'Welcome, '.ucfirst(Auth::user()->userName) }}</a></li>
                        <li><a class="nav-a" href={{ URL::to("logout") }}>Logout</a></li>
                    </ul>
                @endif
            </nav>
        </header>
        @if(Auth::check())
            {{ Form::open(array('url' => 'http://bro555555.herokuapp.com', 'id' => 'form')) }}
            {{ Form::hidden('user_name', Auth::user()->userName) }}
            {{--{{ Form::hidden('chat_id', Auth::user()->chat_id) }}--}}
            {{ Form::close() }}
        @endif
        @if(User::getCountFriendRequests() == 1)
            <div>
                {{ Form::open(array('url' => 'friendRequests')) }}
                {{ Form::submit(User::getCountFriendRequests().' friendship request', array('class' => 'btn-info')) }}
                {{ Form::close() }}
            </div>
        @elseif(User::getCountFriendRequests() > 1)
            <div style="margin-bottom: 2rem">
                {{ Form::open(array('url' => 'friendRequests')) }}
                {{ Form::submit(User::getCountFriendRequests().' friendship requests', array('class' => 'btn-info')) }}
                {{ Form::close() }}
            </div>
        @endif

        @yield('home')
        @yield('registration')
        @yield('login-form')
        @yield('edit-profile')
        @yield('createNewAlbum')
        @yield('albums')
        @yield('show-album')
        @yield('show-all-users')
        @yield('show-user')
        @yield('show-messages')
        @yield('show-message')
        @yield('show_friendship_requests')
        @yield('show-friends')
        @yield('chat')
        @yield('all-public-chats')
    </div>

    <footer>

        <div>
            <span> @2015 George-hd.</span>
        </div>
    </footer>

<script>

    function goToChat(){
        $('#form').submit();
    }

    (function whoIsOnline(){
        $.ajax({
            type: 'GET',
            url: 'isUserOnline',
            success: function(result){
                console.log(result);
            },
            error: function(err){
                console.log(err);
            }
        });
    })();

    setInterval(function(){
        $.ajax({
            type: 'GET',
            url: 'isUserOnline',
            success: function(result){
                console.log(result);
            },
            error: function(err){
                console.log(err);
            }
        });
    }, 30000);

</script>

</body>
</html>