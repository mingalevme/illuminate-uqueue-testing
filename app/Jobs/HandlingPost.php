<?php


namespace App\Jobs;


use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Mingalevme\Illuminate\UQueue\Jobs\Uniqueable;

class HandlingPost implements Uniqueable, ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function uniqueable()
    {
        return 'post-' . intval($this->post->id);
    }

    public function handle()
    {
        Log::debug('Handling a post', [
            'post' => (string) $this->post,
        ]);
    }
}
