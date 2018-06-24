<?php

namespace Tests;

use App\Jobs\HandlingPost;
use App\Jobs\UniqueableJob;
use App\Post;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;

class RedisTest extends \TestCase
{
    public function testSimple()
    {
        Queue::setDefaultDriver('redis');

        Redis::command('DEL', ['queues:default']);

        $id1 = Queue::push(new UniqueableJob(['foo' => 'bar']));
        $id2 = Queue::push(new UniqueableJob(['foo' => 'bar']));

        $this->assertNotNull($id1);
        $this->assertNotNull($id2);
        $this->assertSame($id1, $id2);

        $this->assertCount(1, Redis::command('ZRANGE', ['queues:default', 0, -1]));

        $id3 = Queue::push(new UniqueableJob(['foo2' => 'bar2']));

        $this->assertNotSame($id1, $id3);

        $this->assertCount(2, Redis::command('ZRANGE', ['queues:default', 0, -1]));
    }

    public function testScout()
    {
        Queue::setDefaultDriver('redis');

        Redis::command('DEL', ['queues:default']);

        $post1 = Post::create([
            'title' => 'test',
            'body' => 'body',
        ]);

        $this->assertCount(1, Redis::command('ZRANGE', ['queues:default', 0, -1]));

        $post2 = Post::create([
            'title' => 'test',
            'body' => 'body',
        ]);

        $this->assertCount(2, Redis::command('ZRANGE', ['queues:default', 0, -1]));

        Queue::push(new HandlingPost($post1));

        $this->assertCount(3, Redis::command('ZRANGE', ['queues:default', 0, -1]));

        Queue::push(new HandlingPost($post1));

        $this->assertCount(3, Redis::command('ZRANGE', ['queues:default', 0, -1]));

        Queue::push(new HandlingPost($post2));

        $this->assertCount(4, Redis::command('ZRANGE', ['queues:default', 0, -1]));
    }
}
