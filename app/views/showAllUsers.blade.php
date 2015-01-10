@extends('layouts.defaultLayout')
@section('show-all-users')
    @foreach($users as $user)
        <div class="row">
            <div class="col-md-3">
                <div class="col-md-5">
                    <a href={{ 'user/'.$user->user_id }}><img class="img100x100" src={{ $user->avatar }}></a>
                    <div>
                        @if($user->is_online == 1)
                            <span class="success">{{ 'online' }}</span>
                        @else
                            <span class="error">{{ 'offline' }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 user-data">
                <div>
                    {{ ucfirst($user->userName) }}
                </div>
                <div>
                    {{ $user->email }}
                </div>
            </div>
        </div>
    @endforeach
@endsection