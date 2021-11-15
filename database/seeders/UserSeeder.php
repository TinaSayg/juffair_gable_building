<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@juffairgable.com',
        //     'password' => Hash::make('123456789'),
        //     'number'=>'12345678',
        //     'userType'=>'Admin',
        //     'image'=>'admin.png',
        //     'address'=>'',
        //     'status'=>1,
        // ]);
           
        $user=User::where('userType','Admin')->first();
        
        // $role = Role::create([
        //     'name' => 'Admin',
        //     'slug' => 'admin',
        // ]);
        
        $role=Role::where('slug','admin')->first();
        $user->roles()->attach($role);
        // $permissions = Permission::get();
        // foreach($permissions as $permission){
        //     $permission->roles()->attach($role);   
        // }

        // run seeder command
        // php artisan db:seed --class=UserSeeder
    }
}
