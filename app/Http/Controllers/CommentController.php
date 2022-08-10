<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use App\Events\CommentCreated;

class CommentController extends Controller
{
    public function store(Request $request){
        $post = Post::where('slug', $request->slug)->first();
        
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
        ]);
        
        //create event commentCreated
        event(new CommentCreated($comment, $post));
        
        return redirect()->route('blog.show', ['blog' => $request->slug]);
    }
}
