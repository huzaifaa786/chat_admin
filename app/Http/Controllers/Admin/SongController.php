<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::all();
        return view('admin.song.index')->with('songs', $songs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.song.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->hasFile('avatar_image_url') && $request->hasFile('music_file') && $request->hasFile('lyrics_file')) {

            $fileStorage = new FileHelper();
            $avatarImage = $request->file('avatar_image_url');
            $musicFile = $request->file('music_file');
            $lyricsFile = $request->file('lyrics_file');
            $fileUrls = $fileStorage->storeFiles($avatarImage, $musicFile, $lyricsFile);
            $song = Song::create([
                'name' => $request->name,
                'thumbnail_image_url' => $fileUrls['thumbnail_url'],
                'music_file_url' => $fileUrls['music_url'],
                'lyrics_file_url' => $fileUrls['lyrics_url'],
            ]);
            toastr()->success('Song Stored successfully');
            return redirect()->back();


        } else {
            toastr()->error('Please Select all files');
            return redirect()->back();
        }





    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
