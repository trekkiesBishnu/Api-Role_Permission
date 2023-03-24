<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PremissionRoleCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user_list = Permission::create(['name' => 'user.list','guard_name'=>'api']);
        // $user_view = Permission::create(['name' => 'user.view','guard_name'=>'api']);
        // $user_create = Permission::create(['name' => 'user.create','guard_name'=>'api']);
        // $user_update = Permission::create(['name' => 'user.update','guard_name'=>'api']);
        // $user_delete = Permission::create(['name' => 'user.delete','guard_name'=>'api']);


         // $admin=User::create([
        //     'name'=>'Admin',
        //     'email'=>'admin@gmail.com',
        //     'password'=>bcrypt('password')
        // ]);
        // $admin->assignRole($admin_role);
        // // Role anushar permission 
        // $admin->givePermissionTo([
        //     $user_list,
        //     $user_view,
        //     $user_create,
        //     $user_update,
        //     $user_delete
        // ]);
        $user_role=Role::create(['name'=>'superAdmin','guard_name'=>'api']);
        // $user_role = Role::where(['name' => 'User','guard_name'=>'api'])->first();

         $user=User::create([
            'name'=>'bishnu',
            'email'=>'bishnu@gmail.com',
            'password'=>bcrypt('password')
        ]);
        $user->assignRole($user_role);
        // $user_role->givePermissionTo([
        //     $category_view,
        //     $task_view,
        // ]);
    }
}
