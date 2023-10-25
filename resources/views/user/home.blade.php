@extends('layouts.app')

@section('title', 'Home page')

@section('content')
    @if ($isLogin)
        <div class="flex justify-between items-center">
            <a href="{{ route('user-posts.index') }}" class="btn">View Posts</a>

            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>
    @else
        <a href="{{ route('user.login') }}" class="link">Login</a>
         or
        <a href="{{ route('user.register') }}" class="link">Register</a>
    @endif
@endsection
