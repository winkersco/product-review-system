<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $product = Product::firstOrCreate(['name' => $request->input('product_name')]);
        $user = auth()->user();

        if (Comment::userID($user->id)->productID($product->id)->count() > 2) {
            return ApiResponse::createResponse('You have reached the maximum limit of comments for this product.', null, Response::HTTP_FORBIDDEN);
        }

        $comment = $product->comments()->create([
            'comment' => $request->input('comment'),
            'user_id' => $user->id
        ]);

        $comment->load(['user', 'product']);

        return ApiResponse::createResponse('Comment created successfully.', CommentResource::make($comment), Response::HTTP_CREATED);
    }
}
