<?php

namespace App\Models;

use App\Models\Building;
use App\Models\ComplainStatus;
use App\Models\ComplainSolution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complain extends Model
{
    use HasFactory;
    protected $fillable = [
        'complain_title',
        'complain_description',
        'complain_action',
        'employee_id',
        'building_id',  
    ];

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function complain_status(){
        return $this->belongsTo(ComplainStatus::class, 'complain_status_code', 'complain_status_code');
    }

    public function complain_solution()
    {
        return $this->belongsTo(ComplainSolution::class, 'complain_solution_id', 'id');
    }
}


