<?php

namespace App\Http\Controllers\API\V1\Posts;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\V1\Traits\APIResponse;
use App\Http\Requests\API\V1\Posts\StorePostRequest;
use App\Http\Requests\API\V1\Posts\UpdatePostRequest;

class PostController extends Controller
{

    use APIResponse;

    public function index()
    {
        $posts = Post::all(); // Its Better To Paginate The Data But For The Purposes Of The Task Its Ok. 
        return $posts->count() > 0 ?
            $this->apiResponse(200, "success", null, $posts) :
            $this->apiResponse(200, "There Is No Results Found");
    }

    public function store(StorePostRequest $request)
    {
        $img = $request->file('media');

        $stored_img_name = explode('.', $img->getClientOriginalName())[0] . '-' . time() . '-' .
            $img->getClientOriginalExtension() . '.' . $img->getClientOriginalExtension();

        $request->file('media')->storeAs('public/uploads/posts', $stored_img_name);

        $post =  Post::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'media' => $stored_img_name
        ]);

        return $this->apiResponse(201, "success", null, $post);
    }

    public function show(Post $post)
    {
        return $this->apiResponse(200, "success", null, $post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($request->hasFile('media')) {

            $img = $request->file('media');

            $stored_img_name = explode('.', $img->getClientOriginalName())[0] . '-' . time() . '-' .
                $img->getClientOriginalExtension() . '.' . $img->getClientOriginalExtension();

            $request->file('media')->storeAs('public/uploads/posts', $stored_img_name);
        }

        // We Can Delete The Old Photo From Storage If The Request Contains A New Media

        $post->update([
            'category_id' => $request->category_id ? $request->category_id : $post->category_id,
            'title' => $request->title ? $request->title : $post->title,
            'content' => $request->content ? $request->content : $post->content,
            'media' => $stored_img_name ? $stored_img_name : $post->media
        ]);



        return $this->apiResponse(202, "post updateed successfully", null, $post);
    }

    public function destroy(Post $post)
    {

        // We Can Delete The Post Photos Too.
        // We Can Use SoftDeletes.
        $post->delete();
        return $this->apiResponse(202, "post deleted successfully");
    }
}
