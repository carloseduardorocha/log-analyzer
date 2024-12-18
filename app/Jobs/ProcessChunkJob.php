<?php

namespace App\Jobs;

use App\Contracts\LogServiceContract;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chunk;
    private $log_service;

    public function __construct(array $chunk)
    {
        $this->chunk       = $chunk;
        $this->log_service = app(LogServiceContract::class);
    }

    public function handle(): void
    {
        foreach ($this->chunk as $line)
        {
            $data = json_decode($line, true) ?? null;

            if (isset($data))
            {
                $this->log_service->processLogData($data);
            }
        }
    }
}
