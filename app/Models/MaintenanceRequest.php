<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MaintenanceRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceRequest extends Model
{
    use HasFactory;
    protected $table = 'maintenance_request';

    public function maintenance_request_status(){
        return $this->belongsTo(MaintenanceRequestStatus::class, 'maintenance_request_status_code', 'maintenance_request_status_code');
    }
}
 