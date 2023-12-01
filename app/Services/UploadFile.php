<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UploadFile
{
    public static function uploadFile($file, $folderName = "uploads")
    {
        $response = Http::attach(
            'file',          // API tarafında beklendiği dosya alanı adı
            file_get_contents($file->path()), // Dosyanın içeriği
            $file->getClientOriginalName()    // Dosya adı
        )->attach(
            'folderName', // Ekstra form alanı adı
            $folderName    // folderName değeri
        )->post(env('IMAGE_URL').'/api/upload/file');

        $apiResponse = $response->json();
        return $apiResponse;
    }
}

