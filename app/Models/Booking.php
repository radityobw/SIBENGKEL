<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'preferred_date',
        'preferred_time',
        'complaint',
        'status',
        'service_transaction_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function transaction()
    {
        return $this->belongsTo(ServiceTransaction::class, 'service_transaction_id');
    }
}
