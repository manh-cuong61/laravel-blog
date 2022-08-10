<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use App\Models\Comment;

use App\Models\User;

use Cviebrock\EloquentSluggable\Services\SlugService;

use App\Http\Requests\CreatePostRequest;

use App\Http\Requests\UpdatePostRequest;

use App\Events\PostViewed;

use Illuminate\Session\Store;

use App\Http\Resources\PostResource;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use Illuminate\Http\Response;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
        $this->middleware('view_count');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::get();
        $posts = Post::has('comments', '<=', 2)->orderBy('updated_at', 'DESC')->paginate(5);
        // return PostResource::collection($posts);
        
        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $test = $request->all();
        $newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
        
        $request->image->move(storage_path('app/images'), $newImageName);
        //Storage::disk('local')->put('images/' ,$request->image);
        $test['slug'] = SlugService::createSlug(Post::class, 'slug', $request->title);
        $test['image_path'] = $newImageName;
        $test['user_id'] = auth()->user()->id;
        $post = Post::create($test);
        
        // Post::create([
        //     'title' => $request->input('title'),
        //     'description' => $request->input('description'),
        //     'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
        //     'image_path' => $newImageName,
        //     'user_id' => auth()->user()->id,
        // ]);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Store $session)
    { 
        $post = Post::where('slug', $slug)->firstOrFail();

        //create event postViewed;
        event(new PostViewed($post, $session));
        
        
        return new PostResource($post);
       
       // return response()->file(public_path('images/' . $post->image_path));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('blog.edit')->with('post', Post::where('slug', $slug)->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        $post->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
            'user_id' => auth()->user()->id,
        ]);
        return new PostResource($post);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        
        $post = Post::where('slug', $slug)->firstOrFail();
        //File::delete(public_path("images/$post->image_path"));
        Storage::disk('local')->delete('images/'.$post->image_path);
        $post->delete();
        return new PostResource($post);
    }

    
}
