<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'floor_type_code',
    ];

    public function floor_type(){
        return $this->belongsTo(FloorType::class, 'floor_type_code', 'floor_type_code');
    }
}
