<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;
use App\Models\Post;
class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    private $comment;
    private $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
        $this->queue = 'comment-email';
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this-> subject('Demo Laravel')
        ->view('mail.comment-mail',[
            'comment' => $this->comment,
            'post' => $this->post,
        ]);
    }
}
