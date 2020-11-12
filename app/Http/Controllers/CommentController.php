<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('Authuser');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        if($post->user_id == auth()->user()->id){
            return CommentResource::collection($post->comments);
        }else{
            return response()->json(['error' => 'Not Allowed to show comments of this post']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Post $post)
    {
        if($post->user_id == auth()->user()->id){
            $comment = $post->comments()->create($request->all());
            return response(['comment'=> new CommentResource($comment)] , 201);
        }else{
            return response()->json(['error' => 'Not Allowed to store comment for this post']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post,Comment $comment)
    {
        if($post->user_id == auth()->user()->id){
            return new CommentResource($comment);
        }else{
            return response()->json(['error' => 'Not Allowed to Show Comment for this post']);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post,Request $request, Comment $comment)
    {
        if($post->user_id == auth()->user()->id){
            $comment->update($request->all());
            return response('Update' , 200);
        }else{
            return response()->json(['error' => 'Not Allowed to Update Comment for this post']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post , Comment $comment)
    {
        if($post->user_id == auth()->user()->id){
            $comment->delete();
            return response('Deleted' , 200);
        }else{
            return response()->json(['error' => 'Not Allowed to Delete Comment for this post']);
        }
    }
}
