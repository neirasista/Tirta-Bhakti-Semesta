<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryName',
        'minFlowRate',
        'maxFlowRate',
    ];

    // Relasi: satu kategori punya banyak katalog
    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }
}


/*
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }
}
*/