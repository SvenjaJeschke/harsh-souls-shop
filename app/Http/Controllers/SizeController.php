<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSizeRequest;
use App\Product;
use App\Size;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * @param Product $product
     * @return mixed
     */
    public function index(Product $product) {
        return $product->sizes;
    }

    /**
     * @param CreateSizeRequest $request
     * @return JsonResponse
     */
    public function store(CreateSizeRequest $request): JsonResponse
    {
        Size::create([
            'display_name' => $request->display_name,
            'price' => $request->price,
            'product_id' => $request->product_id
        ]);

        return response()->json(['message' => 'Size was created.']);
    }

    /**
     * @param Size $size
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Size $size): JsonResponse
    {
        $size->delete();
        return response()->json(['message' => 'Size was created.']);
    }
}
