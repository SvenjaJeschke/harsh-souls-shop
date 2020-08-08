<?php


namespace App\Repositories;


use App\Image;
use App\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{

    public function with(array $relations): Builder
    {
        // TODO: Implement with() method.
    }

    public function orderBy(string $orderBy, bool $desc): Builder
    {
        // TODO: Implement orderBy() method.
    }

    public function search(string $search): Builder
    {
        // TODO: Implement search() method.
    }

    public function paginate(int $itemsPerPage, int $page): LengthAwarePaginator
    {
        // TODO: Implement paginate() method.
    }

    public function withAllRelations(): Builder
    {
        // TODO: Implement withAllRelations() method.
    }

    public function find(int $productId): Product
    {
        // TODO: Implement find() method.
    }

    public function update(Product $product, string $displayName, float $price, bool $isActive, string $description): Product
    {
        // TODO: Implement update() method.
    }

    public function create(string $displayName, float $price, bool $isActive, string $description): Product
    {
        // TODO: Implement create() method.
    }

    public function getCoverImage(Product $product): Image
    {
        // TODO: Implement getCoverImage() method.
    }

    public function syncCategories(Product $product, array $categoryIds): Product
    {
        // TODO: Implement syncCategories() method.
    }
}
