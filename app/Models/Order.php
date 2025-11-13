<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'staff_id',
        'order_date',
        'estimated_finish_date',
        'actual_finish_date',
        'status',
        'total_weight',
        'total_price',
        'paid_amount',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'estimated_finish_date' => 'date',
        'actual_finish_date' => 'date',
        'total_weight' => 'decimal:2',
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRemainingAmountAttribute()
    {
        return $this->total_price - $this->paid_amount;
    }
}
