<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Libs\ApiHelpers;
use App\Http\Libs\Roles;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiHelpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $limit = request()->query->get('limit');
        if ($limit != 'all') {
            $per_page = $limit;
        } else {
            $per_page = null;
        }

        $page = request()->query->get('page');

        $user = $request->user();
        $posts = Post::latest();
        if ($user->role == Roles::USER) {
            $posts->where('status', 1);
        }
        if ($per_page) {
            $offset = ((int)$page - 1) * (int)$per_page;
            return PostResource::collection($posts->offset($offset)->paginate($per_page));
        } else {
            return PostResource::collection($posts->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate($this->postStoreUpdateValidationRules());
        $uploadedFile = $data['thumbnail'];
        if ($uploadedFile) {
            $imageName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/images', $imageName);
            $data['thumbnail'] = $imageName;
        }
        $this->authorize('store-post', $request->user());
        $post = Post::create([...$data]);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
         $user = $request->user();
         if ($user->role == Roles::USER && $post->status == 0) {
             abort(403, 'You are not allowed to view this post');
         }
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update-post', $request->user());
        $post->update($request->validate($this->postStoreUpdateValidationRules()));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        $this->authorize('destroy-post', $request->user());
        $post->delete();

        return response(status: 204);
    }
}
