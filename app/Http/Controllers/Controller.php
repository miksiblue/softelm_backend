<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondSuccess($data)
    {
        return response()->json(["data" => $data,], 200);
    }

    protected function respondError($data)
    {
        return response()->json(["data" => $data,], 400);
    }
}
