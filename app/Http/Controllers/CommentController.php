<?php

namespace App\Http\Controllers;

use App\Facades\ProductCommentFileFacade;
use App\Factories\AppendFileOperationFactory;
use App\Factories\ReplaceFileOperationFactory;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    protected $commentRepository;
    protected $productRepository;

    public function __construct(CommentRepositoryInterface $commentRepository, ProductRepositoryInterface $productRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->productRepository = $productRepository;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $product = $this->productRepository->firstOrCreateProduct([
            'name' => $request->input('product_name'),
        ]);
        $user = auth()->user();

        if ($this->commentRepository->hasReachedCommentLimit($user, $product, 2)) {
            return ApiResponse::error(null, 'You have reached the maximum limit of comments for this product.', Response::HTTP_FORBIDDEN);
        }

        $comment = $this->commentRepository->createComment($product, $user, ['comment' => $request->input('comment')]);

        ProductCommentFileFacade::updateFile(
            $product->name,
            $this->commentRepository->getCommentsCount($product),
            config('constants.product_comments_filepath'),
            $product->wasRecentlyCreated
        );

        $data = CommentResource::make($comment);
        return ApiResponse::success($data, 'Comment created successfully.', Response::HTTP_CREATED);
    }
}
