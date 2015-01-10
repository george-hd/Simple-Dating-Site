@extends('layouts.defaultLayout')
@section('home')
@if(Auth::check())
    <img class="img200x200" src={{ Auth::user()->avatar }}>
    <div> {{ Auth::user()->chat_id }} </div>
@else
    <img class="img200x200" src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQFeJYxm0VsMkxYNYSaWQpGG4GGSwmHoB2Hz0AwIKCEwv3CjyWV">
    {{--"../../public/images/default_avatar.jpg">--}}
@endif
@endsection
