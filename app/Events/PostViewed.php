<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Illuminate\Session\Store;

class PostViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $session;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post, Store $session)
    {
        $this->post = $post;
        $this->session = $session;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function isPostViewed($post)
	{
	    $viewed = $this->session->get('viewed_posts', []);

	    return array_key_exists($post->id, $viewed);
	}

	public function storePost($post)
	{
	    $key = 'viewed_posts.' . $post->id;

	    $this->session->put($key, time());
	}
}
