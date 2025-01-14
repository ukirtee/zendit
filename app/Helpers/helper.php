<?php
//Common helper file to use the functions globally


use Illuminate\Support\Facades\Log;

/**
 * To send response in json response
 *
 * @param $result
 * @param string $message
 * @param integer $code
 * @return void
 */
function sendResponse($result, string $message = '', int $code = 200)
{
    return response()->json([
        'success' => true,
        'data'    => is_array($result) ? $result : $result->toArray(),
        'message' => $message,
    ], $code);
}

/**
 * To return error in json response
 *
 * @param array $errors
 * @param string $errorMessage
 * @param integer $code
 * @return void
 */
function sendError(array $errors, string $errorMessage, $code = 400)
{
    return response()->json([
        'success' => false,
        'message' => $errorMessage,
        'errors'  => $errors,
    ], $code);
}
/**
 * To log exception
 *
 * @param \Throwable $exception
 * @return void
 */
function logError(\Throwable $exception)
{
    Log::error(json_encode([
        'message' => $exception->getMessage(),
        'code'    => $exception->getCode(),
        'file'    => $exception->getFile(),
        'line'    => $exception->getLine(),
        'trace'   => $exception->getTrace(),
    ]));
}
