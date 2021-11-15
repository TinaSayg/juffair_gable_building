<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityDeposites extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_first_name',
        'tenant_last_name',
        'tenant_email_address',
        'floor_id',
        'unit_id',
        'security_deposite_total_amount',
    ];

    public function floor(){
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    
}

