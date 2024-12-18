<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $disk;
    private int $chunk_size;

    public function __construct()
    {
        $this->chunk_size = 100;
        $this->disk       = 'public';
    }

    public function handle(): void
    {
        $files = Storage::disk($this->disk)->allFiles();

        foreach ($files as $file)
        {
            $file_path = Storage::disk($this->disk)->path($file);
            $handle    = fopen($file_path, 'r');

            if (!$handle)
            {
                continue;
            }

            $current_chunk = [];

            while (!feof($handle))
            {
                $line = fgets($handle);

                if ($line !== false)
                {
                    $current_chunk[] = $line;
                }

                if (count($current_chunk) === $this->chunk_size || feof($handle))
                {
                    ProcessChunkJob::dispatch($current_chunk)->onQueue('process_chunk');
                    $current_chunk = [];
                }
            }

            fclose($handle);
            Storage::disk($this->disk)->delete($file);
        }
    }
}
