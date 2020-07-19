<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoryController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index() {
        return Category::withAllChildren();
    }
}
