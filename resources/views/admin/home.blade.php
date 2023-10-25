@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @if ($isLogin)
        <div class="flex justify-between items-center">
            <a href="{{ route('admin-posts.index') }}" class="btn">Manage Posts</a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>
    @else
        <a href="{{ route('admin.login') }}" class="link">Login</a>
    @endif
@endsection
