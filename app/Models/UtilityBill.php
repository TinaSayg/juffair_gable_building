<?php

namespace App\Models;

use App\Models\Building;
use App\Models\UtilityBillType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UtilityBill extends Model
{
    use HasFactory;

    public function building(){
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function utility_bill_type(){
        return $this->belongsTo(UtilityBillType::class, 'utility_bill_type_code', 'utility_bill_type_code');
    }
}
