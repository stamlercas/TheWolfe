@extends('layouts.master')

@section('title')
    The Wolfe
@endsection

@section('content')
    @include('includes.message-block')
    <div class='row' style='color:white;'>
        <div class="col-md-6">
            <h3>Sign Up</h3>
            <form action="{{ route('signup') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your Email</label>
                    <input class='form-control' type="email" name='email' id='email' value="{{ Request::old('email') }}" required />
                </div>
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label for="username">Your Username</label>
                    <input class='form-control' type="username" name='username' id='username' value="{{ Request::old('username') }}" required />
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name">Your First Name</label>
                    <input class='form-control' type="text" name='first_name' id='first_name' value="{{ Request::old('first_name') }}" required />
                </div>
                <div class="form- {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <label for="last_name">Your Last Name</label>
                    <input class='form-control' type="text" name='last_name' id='last_name' value="{{ Request::old('last_name') }}" required />
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input class='form-control' type='password' name='password' id='password' required />
                </div>
                <button type='submit' class='btn btn-primary'>Submit</button>
                <input type='hidden' name='_token' value="{{ Session::token() }}"/>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{ route('signin') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your Email</label>
                    <input class='form-control' type="email" name='email' id='email' required />
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input class='form-control' type='password' name='password' id='password' required />
                </div>
                <button type='submit' class='btn btn-primary'>Login</button>
                <input type='hidden' name='_token' value="{{ Session::token() }}"/>
            </form>
        </div>
    </div>
@endsection