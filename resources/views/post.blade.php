@extends('layouts.master')

@section('title')
{{ substr($posts->first()->body, 0, 32) }}
@endsection

@section('content')
@include('includes.post-feed-container')
@endsection
