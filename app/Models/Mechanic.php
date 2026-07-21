<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'expertise'];

    public function transactions()
    {
        return $this->hasMany(ServiceTransaction::class);
    }
}
