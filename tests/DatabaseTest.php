<?php

namespace Tests;

use App\Jobs\HandlingPost;
use App\Jobs\Job;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class DatabaseTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        //$this->seed();
    }

    public function testSimple()
    {
        Queue::setDefaultDriver('database');

        $id1 = Queue::push(new Job(['foo' => 'bar']));
        $id2 = Queue::push(new Job(['foo' => 'bar']));

        $this->assertNotNull($id1);
        $this->assertNotNull($id2);
        $this->assertSame($id1, $id2);

        $this->assertCount(1, DB::select('SELECT * FROM jobs'));

        $id3 = Queue::push(new Job(['foo2' => 'bar2']));

        $this->assertNotSame($id1, $id3);

        $this->assertCount(2, DB::select('SELECT * FROM jobs'));
    }

    public function testScout()
    {
        Queue::setDefaultDriver('database');

        $post1 = Post::create([
            'title' => 'test',
            'body' => 'body',
        ]);

        $this->assertCount(1, DB::select('SELECT * FROM jobs'));

        $post2 = Post::create([
            'title' => 'test',
            'body' => 'body',
        ]);

        $this->assertCount(2, DB::select('SELECT * FROM jobs'));

        Queue::push(new HandlingPost($post1));

        $this->assertCount(3, DB::select('SELECT * FROM jobs'));

        Queue::push(new HandlingPost($post1));

        $this->assertCount(3, DB::select('SELECT * FROM jobs'));

        Queue::push(new HandlingPost($post2));

        $this->assertCount(4, DB::select('SELECT * FROM jobs'));
    }
}
