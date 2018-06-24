<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Mingalevme\Illuminate\UQueue\Jobs\Uniqueable;

class UniqueableJob implements Uniqueable, ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function uniqueable()
    {
        return md5(json_encode($this->data));
    }

    public function handle()
    {
        Log::debug('Handling a job', [
            'data' => $this->data,
        ]);
    }
}
