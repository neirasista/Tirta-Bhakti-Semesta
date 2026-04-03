<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'water_flow_rate',
        'installation_category',
        'budget',
        'tank_type',
        'result_summary',
        'visitor_id'
    ];
}
