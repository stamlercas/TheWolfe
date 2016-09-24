@extends('layouts.master')
@section('title')
    Contact
@endsection

@section('content')
<section>
    <div class='row'>
        <div class='col-md-6 col-md-offset-3'>
            <form action="{{ route('contact') }}" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your Email</label>
                    <input class='form-control' type="email" name='email' id='email' value="{{ Request::old('email') }}" required />
                </div>
                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                    <label for="email">Your Email</label>
                    <textarea class='form-control' name='content' id='content'  rows='2' placeholder="What's on your mind?" required></textarea>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection