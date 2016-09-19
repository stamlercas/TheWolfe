@extends('layouts.master')

@section('title')
About Us
@endsection

@section('content')
<section class='row'>
    <div class='col-md-6 col-md-offset-3'>
        <h3>About Us</h3>
        <p>
            This is a fun and zany way to share your favorite moments with Codey Wolfe with friends through a series of pictures. Snap a photo with your 
            mobile phone in your favorite Codey Wolfe pose, then upload the image to turn it into a memory to keep around forever. We 
            imagine a world more connected through the Wolfe.
        </p>
    </div>
</section>
<section class='row'>
    <div class='col-md-6 col-md-offset-3'>
            Like so:
            <br />
        <img class='img-responsive' src='{{ asset('img/welcome/wolfe.jpg') }}' alt='The Big Bad Wolfe' />
    </div>
</section>
@endsection