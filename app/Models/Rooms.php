<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'reservation_statuses_code',
    ];
   
    public function reservation_status(){
        return $this->belongsTo(ReservationStatus::class, 'reservation_statuses_code', 'reservation_statuses_code');
    }
}
