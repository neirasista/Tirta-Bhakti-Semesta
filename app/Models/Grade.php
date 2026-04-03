<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'gradeName',
        'minFlowRate',
        'maxFlowRate',
    ];

    // Relasi: satu grade punya banyak katalog
    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }
}



/*
class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',          // misal: nama grade (tingkatan pelanggan)
        'description',   // deskripsi opsional
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
*/