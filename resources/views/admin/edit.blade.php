@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="max-w-sm">
        <form method="POST" action="{{ str_replace('localhost', '127.0.0.1:8000', route('admin-form.edit', ['id' => $post->id])) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @error('input')
            <p class="error">{{ $message }}</p>
            @enderror

            <div class="mb-4 mt-2">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" @class(['border-red-500' => $errors->has('title')]) value="{{ $post->title ?? old('title') }}">
                @error('title')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description">Description</label>
                <textarea name="description" id="description" @class(['border-red-500' => $errors->has('description')])>{{ $post->description ?? old('description') }}</textarea>
                @error('description')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image">Image</label>
                <input name="thumbnail" id="image" type="file" accept="image/*" @class(['border-red-500' => $errors->has('thumbnail')])>
                <img src="{{ str_replace('localhost', '127.0.0.1:8000', asset('storage/images/' . $post->thumbnail)) }}" alt="uploaded image" id="uploaded-image" style="display: {{ $post->thumbnail != null ? "block" : "none" }}">
                @error('thumbnail')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="1" {{ $post->status == 1 ? "selected" : "" }}>Enabled</option>
                    <option value="0" {{ $post->status == 0 ? "selected" : "" }}>Disabled</option>
                </select>
            </div>

            <div class="mt-2 flex justify-between">
                <button type="submit" class="btn">Submit</button>
                <a href="{{ str_replace('localhost', '127.0.0.1:8000', url('/admin')) . '/posts' }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        const input_image = document.getElementById('image');
        input_image.onchange = () => {
            const [file] = input_image.files
            if (file) {
                const img_tag = document.getElementById('uploaded-image');
                img_tag.src = URL.createObjectURL(file);
                img_tag.style.display = "block";
            }
        }
    </script>
@endsection
