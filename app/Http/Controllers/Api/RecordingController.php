<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordingController extends Controller
{
    public function store(Request $request)
    {
        $fileStorage = new FileHelper();

        $fileUrl = $fileStorage->storeSingleFile($request->file('recording'), 'public/recording');

        $recording = Recording::create([
            'room_id' => $request->room_id,
            'song_id' => $request->song_id,
            'user_id' => $request->user_id,
            'file_url' => $fileUrl,
        ]);

        return Api::setResponse('recording', $recording);

    }

    public function index()
    {
        $recordings = Recording::where('user_id', Auth::id())->with('room')->with('song')->with('user')->get();
        return Api::setResponse('recordings', $recordings);
    }
}
