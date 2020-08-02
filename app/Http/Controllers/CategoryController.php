<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index() {
        return Category::withAllChildren()->where('is_active', '=', true);
    }

    /**
     * @return Builder[]|Collection
     */
    public function indexAll() {
        return Category::withAllChildren();
    }

    /**
     * @param CreateCategoryRequest $request
     * @return JsonResponse
     */
    public function store(CreateCategoryRequest $request): JsonResponse
    {
        Category::create([
            'display_name' => $request->display_name,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active
        ]);

        return response()->json(['message' => 'Category was created.']);
    }

    /**
     * @param Category $category
     * @param UpdateCategoryRequest $request
     * @return JsonResponse
     */
    public function update(Category $category, UpdateCategoryRequest $request): JsonResponse
    {
        $category->display_name = $request->display_name;
        $category->is_active = $request->is_active;
        $category->save();

        return response()->json(['message' => 'Category was updated.']);
    }

    /**
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json(['message' => 'Category was deleted.']);
    }
}
