<?php

namespace App\Http\Controllers;

use App\Factories\AppendFileOperationFactory;
use App\Factories\ReplaceFileOperationFactory;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCommentRequest;
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

        if ($this->hasReachedCommentLimit($user, $product)) {
            return ApiResponse::createResponse('You have reached the maximum limit of comments for this product.', null, Response::HTTP_FORBIDDEN);
        }

        $comment = $product->comments()->create([
            'comment' => $request->input('comment'),
            'user_id' => $user->id
        ])->load(['user', 'product']);

        $this->updateProductCommentFile($product);

        return ApiResponse::createResponse('Comment created successfully.', CommentResource::make($comment), Response::HTTP_CREATED);
    }

    /**
     * Check if the user has reached the maximum comment limit for the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    private function hasReachedCommentLimit($user, $product)
    {
        return Comment::userID($user->id)->productID($product->id)->count() >= 2;
    }

    /**
     * Update the product comment file based on the product's state.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    private function updateProductCommentFile($product)
    {
        $key = $product->name;
        $value = $product->comments->count() + 1;
        $filepath = config('constants.product_comments_filepath');

        if ($product->wasRecentlyCreated) {
            $factory = new AppendFileOperationFactory($key, $value, $filepath);
        } else {
            $factory = new ReplaceFileOperationFactory($key, $value, $filepath);
        }
        $factory->execute();
    }
}
