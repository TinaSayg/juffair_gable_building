<?php

namespace App\Models;
use App\Models\LeaveStatus;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaves extends Model
{
    use HasFactory; protected $fillable = [
        'leave_start_date',
        'leave_end_date',
        'apply_date',
        'leave_reason',
        'leave_type_code',
        'leave_status_code',
        'leave_document',
        'staff_id',
        
    ];
    public function leave_types(){
        return $this->belongsTo(LeaveType::class, 'leave_type_code', 'leave_type_code');
    }
    public function leaveStatus(){
        return $this->belongsTo(LeaveStatus::class, 'leave_status_code', 'leave_status_code');
    }

}