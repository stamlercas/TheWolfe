@extends('layouts.master')

@section('content')
    @include('includes.message-block')
    <section class='row new-post'>
        <div class='col-md-6 col-md-offset-3'>
            <!--
            <header>
                <h3>What do you have to say?</h3>
            </header>
            -->
            <form action='{{ route('post.create') }}' method='post' id='create-post'>
                <div class='form-group dropzone' id='dropzone'></div>
                <div class='form-group'>
                    <textarea class='form-control' name='body' id='new-post'  rows='2' placeholder="What do you have to say?" required
                              onkeydown="if (event.keyCode == 13) { event.preventDefault(); $('#create-post').submit(); }" ></textarea>
                </div>
                <button id='post-submit' type='submit' class='btn btn-primary'>Create Post</button>
                <input type='hidden' name='image_url' id='image_url' value required />
                <input type='hidden' value='{{ Session::token() }}' name='_token' />
            </form>
        </div>
    </section>
    @include('includes.post-feed-container')
@endsection