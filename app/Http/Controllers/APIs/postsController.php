<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\postResource;
use App\Models\Post;
use Illuminate\Http\Request;

class postsController extends Controller
{
    public function index()
    {
        $posts = Post::with('InstructorOfPost','CourseOfPost')->get();
        if ($posts)
            return response()->json(postResource::collection($posts), 200);
        return response()->json('message -> error not found', 404);
    }
    public function show($id)
    {
        $post = Post::with('InstructorOfPost','CourseOfPost')->first();
        if ($post)
            return response()->json(new postResource($post), 200);
        return response()->json('error not found', 404);
    }
}
