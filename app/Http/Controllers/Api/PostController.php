<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    use \App\ApiResponseTrait;
    public function index(Request $request)
    {
       
        $hotels = PostResource::collection(Post::all());
        
       return $this->apiResponse($hotels, 'Hotels retrieved successfully', 200);
    }

    public function show($id)
    {
        $hotel = Post::find($id);

        if($hotel) {
            return $this->apiResponse(new PostResource($hotel), 'Hotel details retrieved successfully', 200);
        }
            return $this->apiResponse(null, 'An error occurred while retrieving hotel details', 500);
        
    }

    public function store(Request $request)
    {
       
        $post = Post::create($request->all());
        
        

        if($post) {
            return $this->apiResponse(new PostResource($post), 'Post created successfully', 201);
        }
            return $this->apiResponse(null, 'An error occurred while creating the post', 400);
        
    }
}
