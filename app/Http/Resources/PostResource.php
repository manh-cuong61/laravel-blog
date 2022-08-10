<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Comment;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $post_id = $this->id;
        // $comments = Comment::where('post_id', $post_id)->get();
      
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' =>  $this->title,
            'description' =>  $this->description,
            'image_path'=>  $this->image_path,
            'user_id' =>  $this->user_id,
            'view_count' =>  $this->view_count,
            'comments' => $this->comments,
            'user' => $this->user()->where('name', 'cuong123')->first(),
            // 'comments' => $this->posts()->get(),
        ];
    }
}
