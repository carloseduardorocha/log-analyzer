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

    public function __construct()
    {
        $this->disk       = 'public';
    }

    public function handle(): void
    {
        $files = Storage::disk($this->disk)->allFiles();

        foreach ($files as $file)
        {
            $file_path  = Storage::disk($this->disk)->path($file);
            $line_count = self::countFileLines($file_path);
            $chunk_size = self::determineChunkSize($line_count);

            $handle = fopen($file_path, 'r');

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

                if (count($current_chunk) === $chunk_size || feof($handle))
                {
                    ProcessChunkJob::dispatch($current_chunk)->onQueue('process_chunk');
                    $current_chunk = [];
                }
            }

            fclose($handle);
            Storage::disk($this->disk)->delete($file);
        }
    }

    /**
     * Counts the number of lines in a file.
     *
     * @param string $file_path
     * @return int
     */
    private static function countFileLines(string $file_path): int
    {
        $line_count = 0;
        $handle     = fopen($file_path, 'r');

        if ($handle)
        {
            while (!feof($handle))
            {
                fgets($handle);
                $line_count++;
            }

            fclose($handle);
        }

        return $line_count;
    }

    /**
     * Determines the chunk size based on the number of lines in the file.
     *
     * @param int $line_count
     * @return int
     */
    private static function determineChunkSize(int $line_count): int
    {
        if ($line_count <= 100)
        {
            return 1;
        }

        if ($line_count <= 1000)
        {
            $percentage = 0.20;
        }
        elseif ($line_count <= 10000)
        {
            $percentage = 0.15;
        }
        else
        {
            $percentage = 0.10;
        }

        return max((int)($line_count * $percentage), 1);
    }
}
