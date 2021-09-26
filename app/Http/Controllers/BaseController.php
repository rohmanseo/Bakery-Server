<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    /*
     *  200 - Generic everything is OK
        • 201 - Created something OK
        • 202 - Accepted but is being processed async (video is encoding, image is resizing, etc)
        • 400 - Wrong arguments (missing validation)
        • 401 - Unauthorized (no current user and there should be)
        • 403 - The current user is forbidden from accessing this data
        • 404 - That URL is not a valid route, or the item resource does not exist
        • 410 - Data has been deleted, deactivated, suspended, etc
        • 405 - Method Not Allowed (your framework will probably do this for you)
        • 500 - Something unexpected happened and it is the APIs fault
        • 503 - API is not here right now, please try again later
     */

    public static $STATUS_SUCCESS = 200;
    public static $STATUS_WRONG_ARGUMENT = 400;
    public static $STATUS_UNAUTHORIZED = 401;
    public static $STATUS_FORBIDDEN = 403;
    public static $STATUS_MISSING = 404;
    public static $STATUS_INTERNAL_ERROR = 500;

    protected function responseWithItem($item)
    {
        return response()->json([
            'status' => 'success',
            'data' => $item
        ], self::$STATUS_SUCCESS);
    }

    protected function responseSimpleSuccess()
    {
        return response()->json([
            'status' => 'success'
        ], self::$STATUS_SUCCESS);
    }

    protected function responseWithArray($array)
    {

        return response()->json([
            'status' => 'success',
            'data_count' => count($array),
            'data' => $array
        ], self::$STATUS_SUCCESS);
    }

    protected function responseWithCollection($collection)
    {
        return response()->json([
            'status' => 'success',
            'data_count' => $collection->count(),
            'data' => $collection
        ], self::$STATUS_SUCCESS);
    }


    protected function responseWithError($message, $errorCode)
    {
        if ($errorCode == self::$STATUS_SUCCESS) {
            return response()->json([
                'status' => 'error',
                'message' => 'status code invalid'
            ], self::$STATUS_WRONG_ARGUMENT);
        }

        return response()->json([
            'status' => 'error',
            'error_code' => $errorCode,
            'message' => $message
        ], $errorCode);

    }

    protected function responseToArray(array $request, array $valueWantToGet)
    {
        $result = [];
        foreach ($valueWantToGet as $item) {
            $result[$item] = $request[$item];
        }
        return $request;
    }


    protected function responseWithErrorForbidden($message = "Forbidden")
    {
        return $this->responseWithError($message, self::$STATUS_FORBIDDEN);
    }

    protected function responseWithErrorInternalError($message = "Internal Error")
    {
        return $this->responseWithError($message, self::$STATUS_INTERNAL_ERROR);
    }

    protected function responseWithErrorNotFound($message = "Resource Not Found")
    {
        return $this->responseWithError($message, self::$STATUS_MISSING);
    }

    protected function responseWithErrorUnauthorized($message = "Unauthorized")
    {
        return $this->responseWithError($message, self::$STATUS_UNAUTHORIZED);
    }

    protected function responseWithErrorWrongArguments($message = "Wrong Arguments")
    {
        return $this->responseWithError($message, self::$STATUS_WRONG_ARGUMENT);
    }


}
