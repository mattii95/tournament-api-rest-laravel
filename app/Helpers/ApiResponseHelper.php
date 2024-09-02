<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseHelper
{
    
    public static function rollback($e, $msg = 'Failure in the process') {
        DB::rollBack();
        self::throw($e, $msg);
    }

    public static function throw($e, $msg = 'Failure in the process') {
        Log::info($e);
        throw new HttpResponseException(response()->json(
            ['message' => $msg],
            500
        ));
    }

    public static function sendResponse($result, $message = '', $code = 200) {
        if ($code === 204) {
            return response()->noContent();
        }

        $response = [
            'success' => true,
            'data' => $result
        ];

        if (!empty($message)) {
            $response = [...$response, ['message' => $message]];
        }

        return response()->json($response, $code);
    }
    
}
