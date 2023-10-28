<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessPackageResource;
use App\Models\Admin\BussinessPackage;
use Illuminate\Http\Request;

/**
 *
 * @group Packages
 * */
class BusinessPackageController extends Controller
{
    public function index()
    {
        return response()->json([
            'packages' => BusinessPackageResource::collection(BussinessPackage::all())
        ]);
    }
}
