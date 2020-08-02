<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Image;
use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = Product::with(['images', 'coverImage']);

        if ($request->filled('sortBy')) {
            if ($request->sortDesc[0] === 'true') {
                $query->orderByDesc($request->sortBy[0]);
            } else {
                $query->orderBy($request->sortBy[0]);
            }
        }

        if ($request->filled('search')) {
            $query->where('display_name', 'LIKE', "%{$request->search}%");
        }

        return $query->paginate($request->itemsPerPage, '*', 'page', $request->page);
    }

    /**
     * @param Product $product
     * @return Builder|Model|object|null
     */
    public function show(Product $product)
    {
        return Product::with(['categories', 'keywords', 'versions.image', 'discount', 'sizes',
            'images' => static function ($query) {
                $query->where('is_cover', '=', false);
            }])
            ->where('id', '=', $product->id)
            ->first();
    }

    /**
     * @param Product $product
     * @param UpdateProductRequest $request
     * @return JsonResponse
     */
    public function update(Product $product, UpdateProductRequest $request): JsonResponse
    {
        $product->display_name = $request->display_name;
        $product->price = $request->price;
        $product->is_active = $request->is_active;
        $product->description = $request->description;

        $product->save();

        return response()->json(['message' => 'Product details were updated.']);
    }

    /**
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        Product::create([
            'display_name' => $request->display_name,
            'price' => $request->price,
            'is_active' => $request->is_active,
            'description' => $request->description
        ]);

        return response()->json(['message' => 'Product was created.']);
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function getCoverImage(Product $product)
    {
        return $product->coverImage;
    }

    /**
     * @param Image $image
     * @return JsonResponse
     */
    public function setCoverImage(Image $image): JsonResponse
    {
        $image->is_cover = true;
        $image->save();

        return response()->json(['message' => 'The new cover image is set.']);
    }

    /**
     * @param Image $image
     * @return JsonResponse
     */
    public function unsetCoverImage(Image $image): JsonResponse
    {
        $image->is_cover = false;
        $image->save();

        return response()->json(['message' => 'The cover image is unset.']);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCategories(Product $product, Request $request): JsonResponse
    {
        $product->categories()->sync($request->categories);

        return response()->json(['message' => 'Product categories were updated.']);
    }
}
