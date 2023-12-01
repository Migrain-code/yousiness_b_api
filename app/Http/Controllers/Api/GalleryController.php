<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessGalleryResource;
use App\Models\BusinessGallery;
use App\Services\UploadFile;
use Illuminate\Http\Request;

/**
 * @group Gallery
 *
 */
class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'galleries' => BusinessGalleryResource::collection($user->gallery),
        ]);
    }

    public function uploadLogo(Request $request)
    {
        $user = $request->user();

        $gallery = new BusinessGallery();
        $response = UploadFile::uploadFile($request->file('image'), 'businessGallery');
        $gallery->business_id = $user->id;
        $gallery->way = $response["image"];
        $gallery->byte = 45;
        $gallery->name = "businessGallery";
        $gallery->save();

        return response()->json([
            'status' => "success",
            'message' => "Bild wurde hochgeladen",
        ]);
    }
}
