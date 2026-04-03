<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'luasarea',
        'notelp',
        'tanggal_order',
        'catatan',
        'grade_id',
        'tank_type',
        'status',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    // category relasi dihapus karena sudah tidak dipakai
}
