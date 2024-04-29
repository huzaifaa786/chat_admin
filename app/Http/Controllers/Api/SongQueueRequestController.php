<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\SongQueueRequest;
use Illuminate\Http\Request;

class SongQueueRequestController extends Controller
{
    public function store(Request $request)
    {
        $songRequest = SongQueueRequest::create($request->all());
        return Api::setResponse('song_request', $songRequest);
    }
}
