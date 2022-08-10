<?php

namespace App\Listeners;

use App\Events\PostViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncrementViewCount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostViewed  $event
     * @return void
     */
    public function handle(PostViewed $event)
    {
        if (!$event->isPostViewed($event->post))
	    {
	        $event->post->increment('view_count');
	        $event->storePost($event->post);
	    }
    }
}
