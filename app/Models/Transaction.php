<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_no',
        'channel',
        'created_at_manual',
        'created_by',
        'client_name',
        // 'age',
        // 'occupation',
        // 'sex',
        'product_type',
        'product_id',
        'product_name',
        'weight',
        'price',
        // 'duration',
        'scheduled_date',
        'scheduled_time',
        // 'staff_nik',
        // 'location',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'string',
        'status' => 'string',
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_nik', 'nik');
    }

    public function getSubtotalAttribute()
    {
        return ((float) $this->weight) * ((float) $this->price);
    }

    public function getWeightAttribute($value)
    {
        if (Schema::hasColumn($this->getTable(), 'weight_dec')) {
            $w = $this->attributes['weight_dec'] ?? null;
            if ($w !== null) return (float) $w;
        }
        return (float) $value;
    }

    public function setWeightAttribute($value)
    {
        if (Schema::hasColumn($this->getTable(), 'weight_dec')) {
            $this->attributes['weight_dec'] = is_numeric($value) ? round((float) $value, 2) : null;
        }
        $this->attributes['weight'] = is_numeric($value) ? (float) $value : $value;
    }
}
