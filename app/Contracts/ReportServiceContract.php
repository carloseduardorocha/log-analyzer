<?php

namespace App\Contracts;

interface ReportServiceContract
{
    /**
     * Generates a report of total requests grouped by consumer.
     *
     * This method queries the logs to count the number of requests for each consumer
     * and generates a CSV report containing the consumer's ID, UUID, and the total
     * number of requests made by each consumer.
     *
     * @return string The file path or URL to the generated CSV report.
     */
    public function generateRequestsByConsumerReport(): string;

    /**
     * Generates a report of total requests grouped by service.
     *
     * This method queries the logs to count the number of requests for each service
     * and generates a CSV report containing the service's ID, UUID, name, and the total
     * number of requests made for each service.
     *
     * @return string The file path or URL to the generated CSV report.
     */
    public function generateRequestsByServiceReport(): string;

    /**
     * Generates a report of average request times, proxy times, and gateway times
     * grouped by service.
     *
     * This method queries the logs to calculate the average request latency, proxy latency,
     * and gateway latency for each service and generates a CSV report containing the
     * service's ID, UUID, name, and the average times for each latency.
     *
     * @return string The file path or URL to the generated CSV report.
     */
    public function generateAverageTimesByServiceReport(): string;
}
