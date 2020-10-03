<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVersionRequest;
use App\Http\Requests\UpdateVersionRequest;
use App\Image;
use App\Product;
use App\Version;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    /**
     * @param Product $product
     * @return mixed
     */
    public function index(Product $product)
    {
        return $product->versions;
    }

    /**
     * @param Product $product
     * @param CreateVersionRequest $request
     * @return JsonResponse
     */
    public function store(Product $product, CreateVersionRequest $request): JsonResponse
    {
        $version = $product->versions()->create([
            'display_name' => $request->display_name,
            'color' => $request->color,
            'color_code' => $request->color_code,
            'price' => $this->calculatePrice($product, $request),
            'is_active' => $request->is_active,
            'operator' => $request->operator,
            'price_adjustment' => $request->price_adjustment
        ]);

        if ($request->image_id) {
            $image = Image::find($request->image_id);
            $image->version_id = $version->id;
            $image->save();
        }

        return response()->json(['message' => 'Version was created.']);
    }

    /**
     * @param Version $version
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Version $version): JsonResponse
    {
        $version->delete();

        return response()->json(['message' => 'Version was deleted.']);
    }

    /**
     * @param Version $version
     * @param UpdateVersionRequest $request
     * @return JsonResponse
     */
    public function update(Version $version, UpdateVersionRequest $request): JsonResponse
    {
        $version->display_name = $request->display_name;
        $version->color = $request->color;
        $version->color_code = $request->color_code;
        $version->price = $this->calculatePrice($version->product, $request);
        $version->is_active = $request->is_active;
        $version->operator = $request->operator;
        $version->price_adjustment = $request->price_adjustment;
        $version->save();

        if ($request->image_id) {
            $image = Image::find($request->image_id);
            $image->version_id = $version->id;
            $image->save();

            Image::where('version_id', '=', $version->id)
                ->where('id', '!=', $image->id)
                ->each(static function ($image) {
                    $image->version_id = null;
                    $image->save();
                });
        } else {
            Image::where('version_id', '=', $version->id)
                ->each(static function ($image) {
                    $image->version_id = null;
                    $image->save();
                });
        }

        return response()->json(['message' => 'Version was updated.']);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return mixed
     */
    protected function calculatePrice(Product $product, Request $request)
    {
        $price = $product->price;
        if ($request->operator && $request->price_adjustment) {
            if ($request->operator === '+') {
                $price+= $request->price_adjustment;
            }
            if ($request->operator === '-') {
                $price-= $request->price_adjustment;
            }
        }
        return $price;
    }
}
