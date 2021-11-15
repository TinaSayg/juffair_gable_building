<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Owner;
use App\Models\BuildingType;
use App\Models\BuildingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_name',
        'owner_id',
        'building_address_line_1',
        'description',
        'image',
        // 'building_status_code',
    ];

    public function floors(){
        return $this->hasMany(Floor::class, 'building_id', 'id');
    }

    public function building_status(){
        return $this->belongsTo(BuildingStatus::class, 'building_status_code', 'building_status_code');
    }

    public function owner(){
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }
}
