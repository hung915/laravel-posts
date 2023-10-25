@extends('layouts.app')

@section('title', 'The list of posts')

@section('content')
    <nav class="mb-4 flex justify-between">
        <div></div>
        <a href="{{ str_replace('localhost', '127.0.0.1:8000', url('/')) }}" class="btn">Back</a>
    </nav>
    <div class="grid grid-cols-5 text-center border border-gray-500">
        <div class="border border-gray-500 text-lg font-bold">ID</div>
        <div class="border border-gray-500 text-lg font-bold">Thumb</div>
        <div class="col-span-3 border border-gray-500 text-lg font-bold">Title</div>
        @forelse($posts->data as $post)
            <a href="{{ str_replace('localhost', '127.0.0.1:8000', route('user-posts.show', ['id' => $post->id])) }}" class="link border border-gray-500">{{ $post->id }}</a>
            <div class="border border-gray-500 flex items-center justify-center">
                <img src="{{ str_replace('localhost', '127.0.0.1:8000', asset('storage/images/' . $post->thumbnail)) }}"  alt="Thumbnail" class="img-index">
            </div>
            <a href="{{ str_replace('localhost', '127.0.0.1:8000', route('user-posts.show', ['id' => $post->id])) }}" class="col-span-3 link text-left border border-gray-500">{{ $post->title }}</a>
        @empty
            <div>There are no posts</div>
        @endforelse
    </div>

    <div class="flex text-slate-700 gap-2 mt-4 items-center">
        <label for="per_page" class="mb-0 font-semibold">Page</label>
        <select name="per_page" id="per_page" class="border">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="all">All</option>
        </select>
        <div>
            @if ($posts->links)
                @for($i = 1; $i <= $posts->links->last_page; $i++)
                    <a href="{{ "http://127.0.0.1:8000/posts?page=$i&limit=" . $posts->limit }}" class="pagination" id="{{ "page_$i" }}"> {{ $i }}</a>
                @endfor
            @endif
        </div>
    </div>

    <script>
        let select = document.getElementById("per_page");
        select.onchange = function(){
            let optionValue = select.options[select.selectedIndex].value;
            let url = window.location.href.split("?")[0];
            window.location = url + "?limit=" + optionValue;
        }
        const url = new URL(window.location.href);
        const limit_value = url.searchParams.get('limit');
        if (limit_value !== null) {
            let select = document.getElementById('per_page');
            select.value = limit_value;
        }

        async function setActivePage(){
            const url = new URL(window.location.href);
            const current_page = url.searchParams.get('page') !== null ? url.searchParams.get('page') : 1;
            const page_link = document.getElementById(`page_${current_page}`);
            page_link.classList.add('active');
        }
        (async() => {
            await setActivePage()
        })()
    </script>

@endsection
