<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Floor;
use App\Models\Building;
use App\Models\TenantType;
use App\Models\TenantStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $casts = [
        'tenant_facilities_list' => 'array',
    ];

    public function building(){
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function floor(){
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function tenant_status(){
        return $this->belongsTo(TenantStatus::class, 'tenant_status_code', 'tenant_status_code');
    }

    public function tenant_type(){
        return $this->belongsTo(TenantType::class, 'tenant_type_code', 'tenant_type_code');
    }
}
