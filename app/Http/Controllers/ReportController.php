<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;

use App\Contracts\ReportServiceContract;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportController extends Controller
{
    private ReportServiceContract $report_service;

    public function __construct(ReportServiceContract $report_service)
    {
        $this->report_service = $report_service;
    }

    public function processRequestsByConsumerReport(): JsonResponse
    {
        $url = $this->report_service->generateRequestsByConsumerReport();
        return ApiResponse::jsonSuccess(new JsonResource(['url' => $url]), Response::HTTP_OK, 'Request by customer report successfully generated!');
    }

    public function processRequestsByServiceReport(): JsonResponse
    {
        $url = $this->report_service->generateRequestsByServiceReport();
        return ApiResponse::jsonSuccess(new JsonResource(['url' => $url]), Response::HTTP_OK, 'Request by service report successfully generated!');
    }

    public function processAverageTimesByServiceReport(): JsonResponse
    {
        $url = $this->report_service->generateAverageTimesByServiceReport();
        return ApiResponse::jsonSuccess(new JsonResource(['url' => $url]), Response::HTTP_OK, 'Average times by service report successfully generated!');
    }
}
