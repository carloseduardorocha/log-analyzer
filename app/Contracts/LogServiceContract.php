<?php

namespace App\Contracts;

interface LogServiceContract
{
    /**
     * Process the log data and save the associated consumer, service, and log.
     *
     * @param array{
     *     request: array{
     *         method: string,
     *         uri: string,
     *         url: string,
     *         size: string,
     *         querystring: array<string, mixed>,
     *         headers: array<string, string>
     *     },
     *     upstream_uri: string,
     *     response: array{
     *         status: int,
     *         size: string,
     *         headers: array<string, string>
     *     },
     *     authenticated_entity: array{consumer_id: array{uuid: string}},
     *     route: array{
     *         created_at: int,
     *         hosts: mixed,
     *         id: string,
     *         methods: array<string>,
     *         paths: array<string>,
     *         preserve_host: bool,
     *         protocols: array<string>,
     *         regex_priority: int,
     *         service: array{id: string},
     *         strip_path: bool,
     *         updated_at: int
     *     },
     *     service: array{
     *         connect_timeout: int,
     *         created_at: int,
     *         host: string,
     *         id: string,
     *         name: string,
     *         path: string,
     *         port: int,
     *         protocol: string,
     *         read_timeout: int,
     *         retries: int,
     *         updated_at: int,
     *         write_timeout: int
     *     },
     *     latencies: array{proxy: int, gateway: int, request: int},
     *     client_ip: string,
     *     started_at: int
     * } $data
     *
     * @return bool
     */
    public function processLogData(array $data): bool;
}
