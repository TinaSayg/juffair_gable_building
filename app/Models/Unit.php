<?php

namespace App\Models;

use App\Models\Floor;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\RentType;
use App\Models\UnitType;
use App\Models\UnitStatus;
use App\Models\FloorDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number',
        'unit_rent',
        'apartment_type',
        'color_code',
        'no_of_bed_rooms',
        'unit_area',
        'floor_id',
        'unit_status_code',
    ];

    public function building(){
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function floor(){
        return $this->belongsTo(FloorDetail::class, 'floor_id', 'id');
    }

    public function unit_status(){
        return $this->belongsTo(UnitStatus::class, 'unit_status_code', 'unit_status_code');
    }

    public function unit_type(){
        return $this->belongsTo(UnitType::class, 'unit_type_code', 'unit_type_code');
    }

    public function rent_type(){
        return $this->belongsTo(RentType::class, 'rent_type_code', 'rent_type_code');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id', 'unit_id');
    }
}
