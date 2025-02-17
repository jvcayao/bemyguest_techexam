<?php

namespace App\Modules\Entities;


use App\Modules\Factories\ErrorFactory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class Response
{    
    /**
     * error
     *
     * @param  mixed $data
     * @param  mixed $httpStatus
     * @return JsonResponse
     */
    public function error(array $data = [], ?int $httpStatus = null): JsonResponse
    {
        if (empty($httpStatus)) {
            $httpStatus = ErrorFactory::getHttpStatusCode();
        }
        return response()->json($this->json(false, $data), $httpStatus);
    }

    public function success(array $data = [], ?int $httpStatus = null): JsonResponse
    {
        if (empty($httpStatus)) {
            $httpStatus = 200;
        }
        return response()->json($this->json(true, $data), $httpStatus);
    }

    private function json(bool $success = true, array $data = []): array
    {
        $json = [
            "timestamp" => Carbon::now()->toIso8601String(),
            "success" => $success,
            "errors" => ErrorFactory::getErrors(),
            "data" => [],
        ];

        if (!empty($data)) {
            $json['data'] = $data;
        }
        return $json;
    }
}
