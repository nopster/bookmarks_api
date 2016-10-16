<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function errorResponse($error_msg, $code = 403){
        return Response::json([
            'error' => $error_msg
        ], $code);
    }
    protected  function successResponse($data, $code = 200){
        return Response::json($data, $code);
    }
}
