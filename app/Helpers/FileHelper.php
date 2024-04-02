<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public function storeFiles($avatarImage, $musicFile, $lyricsFile)
    {
        $thumbnailFilePath = $this->storeFile($avatarImage, 'public/thumbnails');
        $musicFilePath = $this->storeFile($musicFile, 'public/music');
        $lyricsFilePath = $this->storeFile($lyricsFile, 'public/lyrics');

        return [
            'thumbnail_url' => $this->getFileUrl($thumbnailFilePath),
            'music_url' => $this->getFileUrl($musicFilePath),
            'lyrics_url' => $this->getFileUrl($lyricsFilePath),
        ];
    }

    private function storeFile($file, $storagePath)
    {
        $filenameWithExt = $file->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        return $file->storeAs($storagePath, $fileNameToStore);
    }

    private function getFileUrl($filePath)
    {
        return asset(Storage::url($filePath));
    }
}
