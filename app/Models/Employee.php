<?php

namespace App\Models;

use App\Models\EmployeeType;
use App\Models\EmployeeStatus;
use App\Models\EmployeeDesignation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    public function building(){
        return $this->belongsTo(Building::class, 'building_id', 'id');
   
    }
    public function designation(){
        return $this->belongsTo(EmployeeDesignation::class, 'employee_designation_code', 'employee_designation_code');
    }

    public function employee_status(){
        return $this->belongsTo(EmployeeStatus::class, 'employee_status_code', 'employee_status_code');
    }

    public function employee_type(){
        return $this->belongsTo(EmployeeType::class, 'employee_type_code', 'employee_type_code');
    }
}
