<?php

namespace App\Services;

use App\Models\Log;

use App\Contracts\ReportServiceContract;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService implements ReportServiceContract
{
    public function generateRequestsByConsumerReport(): string
    {
        $data = Log::query()
            ->select('consumer_id', DB::raw('COUNT(*) as total_requests'))
            ->groupBy('consumer_id')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->with('consumer:id,uuid')
            ->get()
            ->map(function ($log) {
                return [
                    'consumer_id'    => $log->consumer_id,
                    'consumer_uuid'  => $log->consumer?->uuid,
                    'total_requests' => $log->total_requests,
                ];
            });

        return self::generateCsv('requests_by_consumer.csv', $data);
    }

    public function generateRequestsByServiceReport(): string
    {
        $data = Log::query()
            ->select('service_id', DB::raw('COUNT(*) as total_requests'))
            ->groupBy('service_id')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->with('service:id,uuid,name')
            ->get()
            ->map(function ($log) {
                return [
                    'service_id'     => $log->service_id,
                    'service_uuid'   => $log->service?->uuid,
                    'service_name'   => $log->service?->name,
                    'total_requests' => $log->total_requests,
                ];
            });

        return self::generateCsv('requests_by_service.csv', $data);
    }

    public function generateAverageTimesByServiceReport(): string
    {
        $data = Log::query()
            ->select(
                'service_id',
                DB::raw('AVG(request_latency) as avg_request_time'),
                DB::raw('AVG(proxy_latency) as avg_proxy_time'),
                DB::raw('AVG(gateway_latency) as avg_gateway_time')
            )
            ->groupBy('service_id')
            ->with('service:id,uuid,name')
            ->get()
            ->map(function ($log) {
                return [
                    'service_id'       => $log->service_id,
                    'service_uuid'     => $log->service?->uuid,
                    'service_name'     => $log->service?->name,
                    'avg_request_time' => round($log->avg_request_time, 2),
                    'avg_proxy_time'   => round($log->avg_proxy_time, 2),
                    'avg_gateway_time' => round($log->avg_gateway_time, 2),
                ];
            });

        return self::generateCsv('average_times_by_service.csv', $data);
    }

    /**
     * Generates a CSV file from the provided data and returns the file url.
     *
     * @param string $file_name
     * @param Collection $data
     *
     * @return string
     */
    private static function generateCsv(string $file_name, Collection $data): string
    {
        $file_name = time().'_'.$file_name;
        $file_path = storage_path('app/public/reports/' . $file_name);
        $handle    = fopen($file_path, 'w');

        if (!$data->isEmpty())
        {
            fputcsv($handle, array_keys($data->first()));
        }

        foreach ($data as $row)
        {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return asset('storage/reports/' . $file_name);
    }
}
