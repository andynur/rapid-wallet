<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('convertYmdToDmy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }
}

if (!function_exists('getBearerTokenByUserName')) {
    /**
     * Generate a base64 token by user name
     *
     * @param string $name
     * @return string
     */
    function getBearerTokenByUserName(string $name)
    {
        return base64_encode($name);
    }
}

if (!function_exists('mapTransactionStatus')) {
    /**
     * Map transaction status code to status text.
     *
     * @param int $status
     * @return string
     */
    function mapTransactionStatus(int $status)
    {
        $statusMap = [
            0 => 'on progress',
            1 => 'success',
            2 => 'failed',
        ];

        return $statusMap[$status] ?? 'unknown';
    }
}

if (!function_exists('logError')) {
    /**
     * Centralized error logging.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function logError($message, $context = [])
    {
        Log::error($message, $context);
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format date to a specific format.
     *
     * @param \DateTimeInterface|string $date
     * @param string $format
     * @return string
     */
    function formatDate($date, $format = 'Y-m-d H:i:s')
    {
        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('formatResponse')) {
    /**
     * Format a standardized JSON response.
     *
     * @param string $msg
     * @param array $data
     * @param int|null $code
     * @param array|null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    function responseJson($msg = '', $data = [], $code = null, $errors = null)
    {
        if (is_null($code)) {
            $http_code = 200;
        } else {
            $http_code = $code;
        }

        return response()->json([
            'code' => $http_code,
            'message' => $msg,
            'data' => $data,
            'errors' => $errors
        ], $http_code);
    }
}

if (!function_exists('generateOrderId')) {
    /**
     * Generate a new order ID by checking the last order ID in the database.
     *
     * @return string
     */
    function generateOrderId()
    {
        // Get the last order ID from the database
        $lastOrder = DB::table('transactions')->orderBy('id', 'desc')->first(['order_id']);

        if ($lastOrder) {
            // Extract the numeric part of the last order ID
            $lastOrderId = $lastOrder->order_id;
            $lastNumericPart = intval(substr($lastOrderId, 3));

            // Increment the numeric part to generate a new order ID
            $newNumericPart = $lastNumericPart + 1;
            $newOrderId = 'ORD' . str_pad($newNumericPart, 5, '0', STR_PAD_LEFT);
        } else {
            // If no order exists, start with ORD00001
            $newOrderId = 'ORD00001';
        }

        return $newOrderId;
    }
}
