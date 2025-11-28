<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getLowStock(int $threshold = 10): Collection
    {
        return Product::where('stock', '<=', $threshold)
            ->orderBy('stock', 'asc')
            ->get();
    }
    
    public function updateStock(int $productId, float $quantity): bool
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return false;
        }
        
        $product->update(['stock' => $quantity]);
        return true;
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function getAll(): Collection
    {
        return Product::orderBy('name')->get();
    }
}
