<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;

use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use File;

class BlogPostController extends Controller
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

        return PostResource::collection(BlogPost::mostComment()->get());
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
    public function store(Request $request)
    {
        //
       
        $data = $request->all();
        $storePostRequest = new StorePostRequest;
        $validator = app('validator')->make($data, $storePostRequest->rules());
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        $user = app('Dingo\Api\Auth\Auth')->user();
      
     
        $data['author_id'] = $user->user_id;
        

        $path = public_path('app/public/assets/file-post');
        if(!File::isDirectory($path)){
            $response = Storage::makeDirectory('public/assets/file-post');
        }

        // change file locations
        if(isset($data['thumbnail'])){
            $data['thumbnail'] = $request->file('thumbnail')->store(
                'assets/file-post', 'public'
            );
        }else{
            $data['thumbnail'] = "";

        }

        $blogPost = BlogPost::create($data);
    

        if ($request->filled('category_id')) {
            $blogPost->category()->attach($request->input('category_id', []));
        }
        if ($request->filled('tag_id'))
        {
            $blogPost->tag()->attach($request->input('tag_id', []));
        }


    
        return response()->json(['data' => $blogPost]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $blogPost)
    {
       
        return new PostResource(BlogPost::findOrFail($blogPost->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $blogPost)
    {

        $this->authorize($blogPost);
        
        $data = $request->all();

        if(isset($data['thumbnail'])){

            // first checking old thumbnail to delete from storage
           $get_item = $blogPost['thumbnail'];

           // change file locations
           $data['thumbnail'] = $request->file('thumbnail')->store(
               'assets/file-post', 'public'
           );

           // delete old thumbnail from storage
           $data_old = 'storage/'.$get_item;
           if (File::exists($data_old)) {
               File::delete($data_old);
           }else{
               File::delete('storage/app/public/'.$get_item);
           }

       }
     
        $blogPost->update($data);

        if ($request->filled('category_id')) {
            $blogPost->category()->sync($request->input('category_id', []));
        }
        if ($request->filled('tag_id'))
        {
            $blogPost->tag()->sync($request->input('tag_id', []));
        }
        
        
        return  response()->json(['data' =>  new PostResource($blogPost->refresh())]);       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $blogPost)
    {

       $this->authorize($blogPost);

       
        $get_item = $blogPost['thumbnail'];

        $data = 'storage/'.$get_item;

        if (File::exists($data)) {
            File::delete($data);
        }else{
            File::delete('storage/app/public/'.$get_item);
        };

        $blogPost->forceDelete();

        
        return response()->json(['message' => 'post was succesfuly deleted']);
    }
}
