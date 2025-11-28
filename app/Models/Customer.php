<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'notes',
    ];

    // Relationships
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Accessor
    public function getTransactionCountAttribute()
    {
        return $this->transactions()->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->transactions()
            ->where('payment_status', 'PAID')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->weight * $transaction->price;
            });
    }
}
