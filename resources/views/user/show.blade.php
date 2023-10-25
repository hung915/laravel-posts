@extends('layouts.app')

{{--@section('title', 'Post Details')--}}

@section('content')
    <nav class="mb-4 flex justify-between">
        <div></div>
        <a href="{{ str_replace('localhost', '127.0.0.1:8000', url('/')) . '/posts' }}" class="btn">Back</a>
    </nav>
    <h1 class="mb-4 text-slate-700 text-3xl font-bold">{{ $post->title }}</h1>
    <div class="mb-4 flex justify-center text-slate-700 gap-4">
        <img src="{{ str_replace('localhost', '127.0.0.1:8000', asset('storage/images/' . $post->thumbnail)) }}"  alt="Thumbnail" class="img-detail">
        <p class="grow">{{ $post->description }}</p>
    </div>
@endsection
