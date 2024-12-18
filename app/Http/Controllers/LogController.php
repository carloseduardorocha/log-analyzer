<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;

use App\Jobs\ProcessFileJob;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class LogController extends Controller
{
    public function process(): JsonResponse
    {
        ProcessFileJob::dispatch()->onQueue('process_file');
        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Log processing has been added to the queue.');
    }
}
