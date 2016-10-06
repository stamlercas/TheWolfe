@extends('layouts.master')
@section('title')
    {{ $user->username }}
@endsection

@section('content')
<div class='row'>
        <div class='col-sm-1'>
            @if ($user->image_url != null)
                        <img src='{{ route('user.image', ['filename' => $user->image_url]) }}' 
                             alt='{{ $user->username }}' height='50'
                             class='img-responsive user-image-thumb'/>
                        @else
                        <img src='{{ asset('img/welcome/wolfe.jpg') }}' alt='The Wolfe' height='50' 
                             class='img-responsive user-image-thumb'/>
                        @endif
        </div>
        <div class='col-sm-6'>
            <header>
                <h3>{{ $user->username }}</h3>
            </header>
            @if (Auth::user() == $user)
            <a href="{{ route('account') }}">Update account info</a>
            @endif
        </div>
</div>
@include('includes.post-feed-container')
@endsection