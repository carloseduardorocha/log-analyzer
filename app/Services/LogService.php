<?php

namespace App\Services;

use Carbon\Carbon;

use App\Contracts\LogServiceContract;

use App\Models\Log;
use App\Models\Service;
use App\Models\Consumer;
use Exception;
use Illuminate\Support\Facades\DB;

class LogService implements LogServiceContract
{
    public function processLogData(array $data): bool
    {
        try
        {
            if (!self::validateDataProperties($data))
            {
                return false;
            }

            DB::transaction(function () use ($data) {

                $service_uuid  = $data['service']['id'];
                $consumer_uuid = $data['authenticated_entity']['consumer_id']['uuid'];

                $consumer = self::getConsumer($consumer_uuid);

                if (!isset($consumer))
                {
                    $consumer = self::createConsumer($consumer_uuid);
                }

                $service = self::getService($service_uuid);

                if (!isset($service))
                {
                    $service = self::createService($data['service']);
                }

                self::createLog($data, $consumer->id, $service->id);
            });

            DB::commit();
            return true;
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Validates the necessary properties in the data array.
     *
     *
     * @param array $data
     * @return bool
     */
    private static function validateDataProperties (array $data): bool // @phpstan-ignore-line
    {
        if (!isset($data['service']['id']))
        {
            return false;
        }

        if (!isset($data['authenticated_entity']['consumer_id']))
        {
            return false;
        }

        if (!isset($data['latencies']['proxy']) || !isset($data['latencies']['gateway']) || !isset($data['latencies']['request']))
        {
            return false;
        }

        return true;
    }

    /**
     * Retrieves a consumer from the database by UUID.
     *
     * @param string $uuid
     * @return Consumer|null
     */
    private static function getConsumer (string $uuid): ?Consumer
    {
        return Consumer::where(['uuid' => $uuid])->first();
    }

     /**
     * Creates a new consumer in the database.
     *
     * @param string $uuid
     * @return Consumer
     */
    private static function createConsumer (string $uuid): Consumer
    {
        return Consumer::create(['uuid' => $uuid]);
    }

    /**
     * Retrieves a service from the database by UUID.
     *
     * @param string $uuid
     *
     * @return Service|null
     */
    private static function getService (string $uuid): ?Service
    {
        return Service::where(['uuid' => $uuid])->first();
    }

    /**
     * Creates a new service in the database.
     *
     * @param array $data
     * @return Service
     */
    private static function createService (array $data): Service // @phpstan-ignore-line
    {
        return Service::create([
            'uuid'     => $data['id'],
            'name'     => $data['name'] ?? null,
            'host'     => $data['host'] ?? null,
            'port'     => $data['port'] ?? null,
            'protocol' => $data['protocol'] ?? null,
        ]);
    }

    /**
     * Creates a log entry in the database.
     *
     * @param array $data
     * @param int $consumer_id
     * @param int $service_id
     *
     * @return Log
     */
    private static function createLog (array $data, int $consumer_id, int $service_id): Log // @phpstan-ignore-line
    {
        return Log::create([
            'consumer_id'     => $consumer_id,
            'service_id'      => $service_id,
            'client_ip'       => $data['client_ip'] ?? null,
            'request_method'  => $data['request']['method'] ?? null,
            'request_uri'     => $data['request']['uri'] ?? null,
            'response_status' => $data['response']['status'] ?? null,
            'proxy_latency'   => $data['latencies']['proxy'] ?? null,
            'gateway_latency' => $data['latencies']['gateway'] ?? null,
            'request_latency' => $data['latencies']['request'] ?? null,
            'started_at'      => Carbon::createFromTimestampMs($data['started_at'] ?? 0 / 1000)->toDateTimeString(),
        ]);
    }
}
