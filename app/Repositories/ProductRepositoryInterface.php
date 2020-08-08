<?php

namespace App\Repositories;


use App\Image;
use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface
{
    /**
     * @param array $relations
     * @return Builder
     */
    public function with(array $relations): Builder;

    /**
     * @param string $orderBy
     * @param bool $desc
     * @return Builder
     */
    public function orderBy(string $orderBy, bool $desc): Builder;

    /**
     * @param string $search
     * @return Builder
     */
    public function search(string $search): Builder;

    /**
     * @param int $itemsPerPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $itemsPerPage, int $page): LengthAwarePaginator;

    /**
     * @return Builder
     */
    public function withAllRelations(): Builder;

    /**
     * @param int $productId
     * @return Product
     */
    public function find(int $productId): Product;

    /**
     * @param Product $product
     * @param string $displayName
     * @param float $price
     * @param bool $isActive
     * @param string $description
     * @return Product
     */
    public function update(Product $product, string $displayName, float $price, bool $isActive, string $description): Product;

    /**
     * @param string $displayName
     * @param float $price
     * @param bool $isActive
     * @param string $description
     * @return Product
     */
    public function create(string $displayName, float $price, bool $isActive, string $description): Product;

    /**
     * @param Product $product
     * @return Image
     */
    public function getCoverImage(Product $product): Image;

    /**
     * @param Product $product
     * @param array $categoryIds
     * @return Product
     */
    public function syncCategories(Product $product, array $categoryIds): Product;
}
