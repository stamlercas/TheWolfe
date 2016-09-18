@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Your Account</h3></header>
            <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
                <div class='row'>
                    <div class="form-group col-sm-6">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" id="first_name">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" id="last_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="file" class="form-control" id="image" />
                </div>
                <button type="submit" class="btn btn-primary">Save Account</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token" />
            </form>
        </div>
    </section>
    @if (Storage::disk('local')->has('users/' . $user->image_url))
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3">
                @if ($user->image_url != null)
                        <img src='{{ route('user.image', ['filename' => $user->image_url]) }}' 
                             alt='{{ $user->first_name . ' ' . $user->last_name }}' height='20'
                             class='img-responsive'/>
                        @else
                        <img src='{{ asset('img/welcome/wolfe.jpg') }}' alt='The Wolfe' height='20' 
                             class='img-responsive'/>
                        @endif
            </div>
        </section>
    @endif
@endsection