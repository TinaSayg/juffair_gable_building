<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'visitor_full_name',
        'visitor_entry_date',
        'visitor_phone_number',
        'floor_id',
        'unit_id',
        'visitor_in_time',
        'visitor_out_time',
        
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

}