<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Catalog extends Model
{
    protected $fillable = [
        'name',
        'description',
        'grade_id',
        'category_id',
        'price',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}


/*
class Catalog extends Model
{
    protected $fillable = ['name','description','grade_id','category_id','price','images'];
    protected $casts = ['images' => 'array'];
    public function grade(){ return $this->belongsTo(Grade::class); }
    public function category(){ return $this->belongsTo(Category::class); }
}
*/