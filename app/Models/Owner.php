<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_first_name',
        'owner_last_name',
        'owner_email_address',
        'owner_mobile_phone',
        'owner_cpr_no',
        'owner_present_address',
        'owner_permanent_address',
        'owner_image',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_owners', 
        'owner_id', 'user_id');
    }

}



