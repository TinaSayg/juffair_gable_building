<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Building;

class MaintenanceCost extends Model
{
    use HasFactory;
    protected $fillable = [
        'maintenance_title',
        'maintenance_description',
        'maintenance_year',
        'maintenance_date',
        'maintenance_cost_total_amount',
        'location_id',
        'floor_id',
        'unit_id',
        'common_area_id',
        'service_area_id',
    ];
}





