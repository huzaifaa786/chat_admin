<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\SongQueueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongQueueRequestController extends Controller
{
    public function store(Request $request)
    {
        $songRequest = SongQueueRequest::create($request->all());
        return Api::setResponse('song_request', $songRequest);
    }
    public function update(Request $request)
    {
        $songRequest = SongQueueRequest::where('room_id', $request->room_id)->where('song_id', $request->song_id)->where('singer_id', $request->singer_id)->first();
        if ($songRequest) {
            $songRequest->update([
                'partner_id' => null,
            ]);

            $updatedSongRequest = SongQueueRequest::find($songRequest->id);
            return Api::setResponse('song_request', $updatedSongRequest);
        } else {
            return Api::setError('Song request not found');
        }

    }

    public function deleteRequest(Request $request)
    {
        $songRequest = SongQueueRequest::where('room_id', $request->room_id)->where('song_id', $request->song_id)->where('singer_id', $request->singer_id)->orWhere('partner_id', $request->singer_id)->first();

        if ($songRequest) {
            $songReq = SongQueueRequest::find($songRequest->id);
            $songReq->delete();
            return Api::setMessage('Song Request Deleted Successfully');
        }
        return Api::setError('Song Request not found');
    }

    public function deleteAllRequest(Request $request)
    {
        SongQueueRequest::where('room_id', $request->room_id)->where('singer_id', Auth::id())->delete();
        return Api::setMessage('Song Requests Deleted Successfully');
    }
}
