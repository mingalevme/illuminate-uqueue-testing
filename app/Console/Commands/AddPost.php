<?php


namespace App\Console\Commands;


use App\Jobs\HandlingPost;
use App\Post;
use Illuminate\Console\Command;

class AddPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:add {title} {body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new post';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $post = Post::create([
            'title' => $this->argument('title'),
            'body' => $this->argument('body')
        ]);

        HandlingPost::dispatch($post);
    }
}
