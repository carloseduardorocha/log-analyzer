<?php

namespace App\Contracts;

interface LogServiceContract
{
    /**
     * Process the log data and save the associated consumer, service, and log.
     *
     * This method validates the incoming data properties, retrieves or creates the
     * consumer and service entries, and then logs the data into the database within a transaction.
     *
     * @param array $data
     * @return bool
     */
    public function processLogData(array $data): bool;
}
