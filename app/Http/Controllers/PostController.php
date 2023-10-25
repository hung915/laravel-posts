<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Http\Libs\Roles;

class PostController extends Controller
{
    public function indexForUser(Request $request)
    {
        $per_page = request()->query->get('limit') ?? '5';
        $page_number = request()->query->get('page') ?? '1';
        $posts = $this->getPosts($request, Roles::USER, $per_page, $page_number);
        return view('user.index', compact('posts'));
    }

    public function indexForAdmin(Request $request)
    {
        $per_page = request()->query->get('limit') ?? '5';
        $page_number = request()->query->get('page') ?? '1';
        $posts = $this->getPosts($request, Roles::ADMIN, $per_page, $page_number);
        return view('admin.index', compact('posts'));
    }

    protected function getPosts(Request $request, string $role, string $per_page, string $page_number)
    {
        $authToken = session($role . '_access_token');;
        $request = Request::create('/api/posts', 'GET', ['limit' => $per_page, 'page' => $page_number]);
        $request->headers->add([
            'Authorization' => 'Bearer ' . $authToken,
            'Accept' => 'application/json'
        ]);

        $res = app()->handle($request);

        if ($res->getStatusCode() == 200) {
            $data = $res->getData();
            if ($data->links) {
                $query_str = parse_url($data->links->last, PHP_URL_QUERY);
                parse_str($query_str, $query_params);
                $last_page = $query_params['page'];
                $data->links->last_page = $last_page;
                $data->limit = $per_page;
            }
            return $data;
        } else {
            return [];
        }
    }

    public function showForUser(Request $request, int $id)
    {
        $post = $this->getPostDetail($id, Roles::USER);
        return view('user.show', ['post' => $post->data]);
    }

    public function showForAdmin(Request $request, int $id)
    {
        $post = $this->getPostDetail($id, Roles::ADMIN);
        return view('admin.show', ['post' => $post->data]);
    }

    protected function getPostDetail(int $id, string $role)
    {
        $authToken = session($role . '_access_token');
        $request = Request::create("/api/posts/$id");
        $request->headers->add([
            'Authorization' => 'Bearer ' . $authToken,
            'Accept' => 'application/json'
        ]);

        $res = app()->handle($request);

        if ($res->getStatusCode() == 200) {
            return $res->getData();
        } else {
            return [];
        }
    }

    public function add(Request $request)
    {
        return view('admin.add');
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $authToken = session('admin_access_token');
        $req = Request::create('/api/posts', 'POST', $data);
        $req->headers->add([
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type' => 'multipart/form-data'
        ]);
        $res = app()->handle($req);
        if ($res->getStatusCode() == 201) {
            $post = $res->getData()->data;
            $url = str_replace('localhost', '127.0.0.1:8000',route('admin-posts.index') . "/" . $post->id);
            return redirect($url)->with('success', "Post " . $post->id . " created!");
        } else {
            return [];
        }
    }

    public function edit(Request $request, int $id)
    {
        $post = $this->getPostDetail($id, Roles::ADMIN);
        return view('admin.edit', ['post' => $post->data]);
    }

    public function update(PostRequest $request, int $id)
    {
        $data = $request->validated();
        $authToken = session('admin_access_token');
        $req = Request::create("/api/posts/$id", 'PUT', $data);
        $req->headers->add([
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type' => 'multipart/form-data'
        ]);
        $res = app()->handle($req);
        if ($res->getStatusCode() == 200) {
            $post = $res->getData()->data;
            $url = str_replace('localhost', '127.0.0.1:8000',route('admin-posts.index') . "/" . $post->id);
            return redirect($url)->with('success', "Post " . $post->id . " updated!");
        } else {
            return [];
        }
    }

    public function destroy(Request $request, int $id)
    {
        $authToken = session('admin_access_token');
        $req = Request::create("/api/posts/$id", 'DELETE');
        $req->headers->add([
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type' => 'application/json'
        ]);
        $res = app()->handle($req);
        if ($res->getStatusCode() == 204) {
            $url = str_replace('localhost', '127.0.0.1:8000',route('admin-posts.index'));
            return redirect($url)->with('success', "Post " . $id . " deleted!");
        } else {
            return [];
        }
    }
}
