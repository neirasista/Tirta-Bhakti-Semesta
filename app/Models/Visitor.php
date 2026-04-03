<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_code',    // misal ID unik pengunjung
        'ip_address',
        'device_info',
        'location',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
