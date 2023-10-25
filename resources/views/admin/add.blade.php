@extends('layouts.app')

@section('title', 'Add New Post')

@section('content')
    <div class="max-w-sm">
        <form method="POST" action="{{ route('admin-form.add') }}" enctype="multipart/form-data">
            @csrf

            @error('input')
            <p class="error">{{ $message }}</p>
            @enderror

            <div class="mb-4 mt-2">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" @class(['border-red-500' => $errors->has('title')]) value="{{ old('title') }}">
                @error('title')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description">Description</label>
                <textarea name="description" id="description" @class(['border-red-500' => $errors->has('description')])>{{ old('description') }}</textarea>
                @error('description')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image">Image</label>
                <input name="thumbnail" id="image" type="file" accept="image/*" @class(['border-red-500' => $errors->has('thumbnail')])>
                <img src="#" alt="uploaded image" id="uploaded-image" style="display: none">
                @error('thumbnail')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn">Submit</button>
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
