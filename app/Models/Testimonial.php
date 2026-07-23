<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'vehicle',
        'content',
        'rating',
        'is_active',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
