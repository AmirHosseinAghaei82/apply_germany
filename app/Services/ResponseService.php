<?php 

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ResponseService 
{

    public static function responseMessage($message, $status, $statusCode, $data = [], ) : JsonResponse
    {

        $response = [
            'status' => $status,
            'message' => $message !== '' ? $message : null
        ];

        if ($response['message'] === null) {

            unset($response['message']);
            
        }

    
        if (!empty($data) && is_array($data)) {

            $response = array_merge($response, $data);
            
        }

        return Response::json($response, $statusCode);

    }

    public static function ServerMessage($message, $logMessage, Exception $e)
    {

        $response = [
            'status' => false,
            'message' => $message != '' ? $message : null
        ];
        
        if($response['message'] == null) {

            unset($response['message']);

        }

        Log::error($logMessage, [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine()
        ]);

        return Response::json([
            $response
        ], 500);

    }

}