<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\DuetRequest;
use Illuminate\Http\Request;

class DuetRequestController extends Controller
{
    public function createDuetRequest(Request $request)
    {
        try {
            $duetRequest = DuetRequest::create($request->all());
            return Api::setResponse('duetRequest', $duetRequest);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
