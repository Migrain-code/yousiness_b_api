<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessGalleryResource;
use App\Models\BusinessGallery;
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

        $path = image('storage/' . $request->file('image')->store('businessGallery'));
        $gallery = new BusinessGallery();
        $gallery->business_id = $user->id;
        $gallery->way = $path;
        $gallery->byte = 45;
        $gallery->name = "businessGallery";
        $gallery->save();

        return response()->json([
            'status' => "success",
            'message' => "Bild wurde hochgeladen",
        ]);
    }
}
