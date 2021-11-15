<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'posted_by',
        'assigned_id',
        'request_status_code'
    ];

    public function request_status(){
        return $this->belongsTo(RequestStatus::class, 'request_status_code', 'request_status_code');
    }
}
