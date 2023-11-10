<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessCommentResource;
use App\Models\BusinessComment;
use Illuminate\Http\Request;

/**
 * @group Comment
 */
class CommentController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->user();

        return response()->json([
           'comments' => BusinessCommentResource::collection($business->comments),
        ]);
    }

    public function detail(Request $request)
    {
        $comment = BusinessComment::find($request->comment_id);
        return response()->json([
            'comment_detail' => BusinessCommentResource::make($comment),
        ]);
    }
}
