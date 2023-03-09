<?php

namespace App\Http\Controllers\API\V1\Posts;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\V1\Traits\APIResponse;
use App\Http\Controllers\API\V1\Traits\ImageUpload;
use App\Http\Requests\API\V1\Posts\StorePostRequest;
use App\Http\Requests\API\V1\Posts\UpdatePostRequest;
use App\Models\PostCarousel;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{

    use APIResponse, ImageUpload;

    public function index()
    {
        $posts = Post::all(); // Its Better To Paginate The Data But For The Purposes Of The Task Its Ok. 
        return $posts->count() > 0 ?
            $this->apiResponse(200, "success", null, $posts) :
            $this->apiResponse(200, "There Is No Results Found");
    }

    public function store(StorePostRequest $request)
    {
        // Post
        $stored_img_name = $this->uploadImage($request, 'media', 'public/uploads/posts');

        $post =  Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'media' => $stored_img_name
        ]);

        $post->categories()->attach($request->categories);
        // Post End

        // Post Carousel

        $carousels = [];
        foreach ($request->carousel as $carousel) {
            if ($carousel['slide_img'] instanceof UploadedFile) {

                $stored_img_name = $this->uploadCarouselImages(
                    $carousel['slide_img'],
                    "public/uploads/posts/$post->id/carousels"
                );
            }
            $carousels[] = PostCarousel::create([
                'post_id' => $post->id,
                'is_ad' => $carousel['is_ad'],
                'content' => $carousel['content'],
                'see_more' => $carousel['see_more'],
                'img' => $stored_img_name ?? null,
                'pub_num' => $carousel['pub_num'] ?? null,
                'slot_num' => $carousel['slot_num'] ?? null,
                'ad_script' => $carousel['ad_script'] ?? null,
            ]);
        }

        return $this->apiResponse(201, "success", null, [
            "post" => $post,
            'carousel' => $carousels
        ]);
    }

    public function show(Post $post)
    {
        $post->load('carousels');
        return $this->apiResponse(200, "success", null, [
            "post" => $post,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->load('carousels');

        if ($request->hasFile('media')) {

            $stored_img_name = $this->uploadImage($request, 'media', 'public/uploads/posts');
        }
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

    public function addPostCarousel(Request $request, Post $post)
    {
        return 'ok';
    }
}
