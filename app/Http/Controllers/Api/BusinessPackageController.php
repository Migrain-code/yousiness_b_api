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
            'monthly_packages' => BusinessPackageResource::collection(BussinessPackage::where('type', 0)->get()),
            'yearly_packages' => BusinessPackageResource::collection(BussinessPackage::where('type', 1)->get())
        ]);
    }
}
