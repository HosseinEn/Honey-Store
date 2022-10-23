<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public const PAGINATEDBY = 3;

    public function calculate($request) {
        return max(0, (is_numeric($request->query("page")) ? $request->query("page") : 1)  - 1) * self::PAGINATEDBY;
    }
}
