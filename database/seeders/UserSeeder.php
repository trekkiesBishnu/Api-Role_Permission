<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $category_view = Permission::where(['name' => 'category.view','guard_name'=>'api'])->first();
        $category_create = Permission::where(['name' => 'category.create','guard_name'=>'api'])->first();
        $category_update = Permission::where(['name' => 'category.update','guard_name'=>'api'])->first();
        $category_delete = Permission::where(['name' => 'category.delete','guard_name'=>'api'])->first();

        $task_view = Permission::where(['name' => 'task.view','guard_name'=>'api'])->first();
        $task_create = Permission::where(['name' => 'task.create','guard_name'=>'api'])->first();
        $task_update = Permission::where(['name' => 'task.update','guard_name'=>'api'])->first();
        $task_delete = Permission::where(['name' => 'task.delete','guard_name'=>'api'])->first();


        $admin_role = Role::where(['name' => 'Admin','guard_name'=>'api'])->first();

        // direct permission 
        $admin_role->givePermissionTo([
            $category_view,
            $category_create,
            $category_update,
            $category_delete,

            $task_view,
            $task_create,
            $task_update,
            $task_delete,

        ]);
        $admin=User::where('name','Admin')->first();
        $admin->assignRole($admin_role);
        $admin->givePermissionTo([
            $category_view,
            $category_create,
            $category_update,
            $category_delete,

            $task_view,
            $task_create,
            $task_update,
            $task_delete,
        ]);
       
        $super_role=Role::where(['name'=>'superAdmin'])->first();
        $super_role->givePermissionTo([
            $category_create,
            $category_update,
            $category_view,
            $task_view,
            $task_create,
            $task_update,

        ]);

        $user_role = Role::where(['name' => 'User','guard_name'=>'api'])->first();
      
        $user_role->givePermissionTo([
            $category_view,
            $task_view,
        ]);
    }
}
