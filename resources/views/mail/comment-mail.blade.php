{{-- @component('mail::message') --}}
{{-- # Introduction --}}
Bạn có một bình luận mới <i>{{$comment->content}}</i> từ bài viết <strong>{{$post->title}}</strong>

{{-- @component('mail::button', ['url' => ''])
Button Text 
 @endcomponent --}}
<br>
Thanks,<br>
{{ config('app.name') }}
{{-- @endcomponent --}}



