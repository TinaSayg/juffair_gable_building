<?php

namespace App\Models;

use App\Models\ServiceContractStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceContract extends Model
{
    use HasFactory;

    
    public function service_contract_status(){
        return $this->belongsTo(ServiceContractStatus::class, 'service_contract_status_code', 'service_contract_status_code');
    }
}
