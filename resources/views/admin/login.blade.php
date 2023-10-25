@extends('layouts.app')

@section('content')
    <div class="max-w-sm">
        <form method="POST" action="{{ route('admin-form.login') }}">
            @csrf

            @error('input')
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="mb-4 mt-2">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" @class(['border-red-500' => $errors->has('email')])>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" @class(['border-red-500' => $errors->has('password')])>
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-2">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
    </div>
@endsection
