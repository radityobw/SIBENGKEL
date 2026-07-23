<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'spare_part_id',
        'qty',
        'price_at_purchase',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function sparePart(): BelongsTo
    {
        return $this->belongsTo(SparePart::class);
    }
}
