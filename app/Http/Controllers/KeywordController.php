<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKeywordRequest;
use App\Keyword;
use App\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * @param Product $product
     * @return mixed
     */
    public function index(Product $product) {
        return $product->keywords;
    }

    /**
     * @param Product $product
     * @param CreateKeywordRequest $request
     * @return JsonResponse
     */
    public function store(Product $product, CreateKeywordRequest $request): JsonResponse
    {
        $keyword = Keyword::query()->where('name', '=', $request->name)->first();

        if ($keyword) {
            $product->keywords()->attach($keyword->id);
        } else {
            $product->keywords()->create([
                'name' => $request->name
            ]);
        }

        return response()->json(['message' => 'Keyword was added to the product.']);
    }

    /**
     * @param Keyword $keyword
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Keyword $keyword, Product $product): JsonResponse
    {
        $product->keywords()->detach($keyword->id);

        if (!$keyword->products->count()) {
            $keyword->delete();
        }

        return response()->json(['message' => 'Keyword was removed.']);
    }
}
