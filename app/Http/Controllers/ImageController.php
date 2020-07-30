<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController extends Controller
{
    /**
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Product $product, Request $request): JsonResponse
    {
        foreach ($request->file('images') as $image) {
            $storedFile = Storage::disk('public')->putFile('products', $image);

            $product->images()->create([
                'version_id' => null,
                'name' => $storedFile,
                'storage_url' => Storage::url($storedFile),
                'original_name' => $image->getClientOriginalName(),
                'path' => Storage::disk('public')->path($storedFile),
                'file_size' => $image->getSize(),
                'file_extension' => $image->getClientOriginalExtension(),
                'is_cover' => false,
                'is_visible' => false
            ]);
        }

        return response()->json(['message' => 'Images were uploaded.']);
    }

    /**
     * @param Image $image
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Image $image): JsonResponse
    {
        Storage::disk('public')->delete($image->name);
        $image->delete();

        return response()->json(['message' => 'Image was deleted.']);
    }

    /**
     * @param Image $image
     * @return BinaryFileResponse
     */
    public function show(Image $image): BinaryFileResponse
    {
        return response()->download($image->path);
    }
}
