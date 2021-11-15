<?php

namespace App\Models;


use App\Models\Unit;
use App\Models\FloorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'floor_type_code',
    ];

    public function floor_type(){
        return $this->belongsTo(FloorType::class, 'floor_type_code', 'floor_type_code');
    }
}
