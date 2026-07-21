<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'user_id', 'mechanic_id', 'type',
        'complaint', 'cost', 'status', 'transaction_date'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }
}
