<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepositoryInterface;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Response;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * ProductController constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->productRepository->getAllProducts();
        $data = ProductResource::collection($paginator->items());
        return ApiResponse::paginate($paginator, $data, 'Products fetched successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productRepository->createProduct([
            'name' => $request->input('name'),
        ]);
        $data = ProductResource::make($product);
        return ApiResponse::success($data, 'Product created successfully.', Response::HTTP_CREATED);
    }
}
