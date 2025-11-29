<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;

class InventoryService
{
    /**
     * Kurangi stok produk
     */
    public function deductStock(Product $product, float $quantity, ?int $transactionId = null): bool
    {
        if ($product->stock < $quantity) {
            throw new \Exception("Stok {$product->name} tidak mencukupi. Tersedia: {$product->stock}, Dibutuhkan: {$quantity}");
        }
        
        $product->decrement('stock', $quantity);
        
        // Log stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'transaction_id' => $transactionId,
            'type' => 'out',
            'quantity' => $quantity,
            'notes' => 'Stock deduction for transaction',
        ]);
        
        return true;
    }
    
    /**
     * Tambah stok produk
     */
    public function addStock(Product $product, float $quantity, ?string $notes = null): bool
    {
        $product->increment('stock', $quantity);
        
        // Log stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'transaction_id' => null,
            'type' => 'in',
            'quantity' => $quantity,
            'notes' => $notes ?? 'Stock addition',
        ]);
        
        return true;
    }
    
    /**
     * Cek apakah produk low stock
     */
    public function isLowStock(Product $product, int $threshold = 10): bool
    {
        return $product->stock <= $threshold;
    }

    /**
     * Get produk dengan stok rendah
     */
    public function getLowStockProducts(int $threshold = 10)
    {
        return Product::where('stock', '<=', $threshold)->get();
    }
}
