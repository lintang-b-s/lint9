<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PostComment\StorePostCommentRequest;



use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use File;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CommentResource::collection(PostComment::all());
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
    public function store(StorePostCommentRequest $request)
    {
       
        $user = app('Dingo\Api\Auth\Auth')->user();
   
        $data = $request->all();
        $data['author_id'] = $user->user_id;
        
     

        $comment = PostComment::create($data);

        return response()->json(['data' => new CommentResource($comment)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
    {
        //
        // dd($postComment->id);
        return new CommentResource(PostComment::findOrFail($postComment->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function edit(PostComment $postComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostComment $postComment)
    {
        
        $this->authorize('post_comment.update',$postComment);
        $data = $request->all();
        $postComment->update($data);
        
        return response()->json(['data'=> new CommentResource($postComment->refresh())]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostComment $postComment)
    {
        //

        $this->authorize('post_comment.delete',$postComment);

        $postComment->forceDelete();

        return redirect()->back()
            ->withStatus('comment was deleted!');
    }
}
