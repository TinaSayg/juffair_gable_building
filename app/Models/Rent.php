<?php

namespace App\Models;

use App\Models\Floor;
use App\Models\Building;
use App\Models\RentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rent extends Model
{
    use HasFactory;

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function floor(){
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function building(){
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function rent_type(){
        return $this->belongsTo(RentType::class, 'rent_type_code', 'rent_type_code');
    }
}
