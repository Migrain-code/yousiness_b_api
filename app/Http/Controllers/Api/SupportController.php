<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportAddRequest;
use App\Http\Resources\BusinessSupportResource;
use App\Models\Support;
use Illuminate\Http\Request;

/**
 * @group Support
 *
 */
class SupportController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->user();
        return response()->json([
            'support_list' => BusinessSupportResource::collection($business->supports),
        ]);
    }

    public function store(SupportAddRequest $request)
    {
        $business = $request->user();
        $support = new Support();
        $support->business_id = $business->id;
        $support->subject = $request->input('subject');
        $support->content = $request->input('content');
        if ($support->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Destek Talebi Oluşturuldu"
            ]);
        }
    }

    public function detail(Request $request)
    {
        $business = $request->user();
        $support = Support::find($request->support_id);
        if ($support){
            return response()->json([
                'support_detail' => BusinessSupportResource::make($support)
            ]);
        } else{
            return response()->json([
                'status' => "warning",
                'message' => "Destek Talebi Bulunamadı"
            ]);
        }
    }
}
