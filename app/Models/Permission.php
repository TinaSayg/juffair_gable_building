<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    public function module(){
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function roles() {

        return $this->belongsToMany(Role::class,'roles_permissions');
            
    }
 
     public function users() {
     
        return $this->belongsToMany(User::class,'users_permissions');
            
     }
}
