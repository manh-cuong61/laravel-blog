@extends('layouts.app')
@section('content')
<div class="w-4/5 m-auto text-center">
    <div class="py-15">
        <h1 class="text-6xl">
            {{$post->title}}
        </h1>
    </div>
</div>
<div class="w-4/5 m-auto pt-20">
   <span class="text-gray-500">
        By <span class="font-bold italic text-gray-800">{{$post->user->name}}</span>, Created on {{date('jS M Y', strtotime($post->updated_at))}}
   </span>
</div>
<p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light content">
    {{$post->description}}
</p>

<h2 class="title-comment"><strong>Comments</strong></h2>
<hr>
@foreach ($comments as $comment )
<div class="comment">
    <div class="comment-ava">
        <img style="width: 35px; height: 35px;" src="https://static2.yan.vn/YanNews/2167221/202102/facebook-cap-nhat-avatar-doi-voi-tai-khoan-khong-su-dung-anh-dai-dien-e4abd14d.jpg" alt="">
    </div>
    <div class="comment-detail">
        <span>{{$comment ->user->name}}</span>
        <span class="time">{{date('jS M Y', strtotime($comment->updated_at))}}</span>
        <p >{{$comment->content}}</p>
        <a  href="" class="reply">Reply</a>
    </div>
</div>  
@endforeach


@if (Auth::check())
    <form class="form-comment"
    action="/blog/{{$post->slug}}/comment"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    <input 
        type="text"
        name="content"
        placeholder="Comment..."
        class="bg-transparent block border-b-2 w-full h-5 text-1xl my-2
        outline-none">
    <button 
        type="submit"
        class="submit-comment">
        Add comment
    </button>
</form>
@endif

@endsection
