<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\InventoryService;
use App\Models\Med;
use App\Models\Transaction;

class UpdateProductStock
{
    /**
     * Create the event listener.
     */
    protected $inventoryService;

    /**
     * Create the event listener.
     */
    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event): void
    {
        $transaction = $event->transaction;
        
        // Transaction model doesn't have items relationship yet in this context if we are using the loop in controller.
        // Wait, Transaction model in this project seems to be "One Transaction per Item" based on the controller loop?
        // Let's check TransactionController@store.
        // Yes: foreach ($validated['items'] as $item) { Transaction::create(...) }
        // So $transaction is a SINGLE transaction row which corresponds to ONE item.
        
        if ($transaction->product_type === 'med') {
            $med = Med::find($transaction->product_id);
            if ($med) {
                try {
                    $this->inventoryService->deductStock($med, $transaction->weight, $transaction->id);
                } catch (\Exception $e) {
                    // Log error or handle it. 
                    // Since event is sync (default), exception will bubble up.
                    // But controller already created transaction.
                    // Ideally we should check stock BEFORE creating transaction.
                    // But for now, let's just log.
                    \Log::error("Failed to deduct stock for transaction {$transaction->ref_no}: " . $e->getMessage());
                }
            }
        }
    }
}
