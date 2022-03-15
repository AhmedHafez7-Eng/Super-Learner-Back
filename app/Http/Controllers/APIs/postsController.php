<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\posts\Store;
use App\Http\Resources\postResource;
use App\Models\Post;
use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;

class postsController extends Controller
{
    public function index()
    {
        $posts = Post::with('InstructorOfPost', 'CourseOfPost')->get();
        if ($posts)
            return response()->json(postResource::collection($posts), 200);
        return response()->json('message -> error not found', 404);
    }
    public function show($id)
    {
        $post = Post::with('InstructorOfPost', 'CourseOfPost')->where('course_id', '=', $id)->get();
        if ($post)
            return response()->json($post, 200);
        return response()->json('error not found', 404);
    }
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->instructor_id = $request->instructor_id;
        $post->course_id = $request->course_id;
        $post->save();
        return response()->json(['Post Created Successfully', 200]);
    }
    public function update(Request $request, $id)
    {
        $post = Post::with('InstructorOfPost', 'CourseOfPost')->find($id);
        if ($post) {
            if (isset($request->title))
                $post->title = $request->title;
            if (isset($request->body))
                $post->body = $request->body;
            if (isset($request->instructor_id))
                $post->instructor_id = $request->instructor_id;
            if (isset($request->course_id))
                $post->course_id = $request->course_id;
            $post->save();
            return response()->json('Record Updated', 200);
        }
        return response()->json('Error Post Not Found', 404);
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if ($post)
            $post->delete();
        return response()->json('Error Record Not Found', 404);
    }
}