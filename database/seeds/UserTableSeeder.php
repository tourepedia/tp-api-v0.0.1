<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, "super_admin")->create()->each(function ($u) {
            $u->roles()->save(
                // assign the super admin role
                factory(App\Models\Tags\UserRole::class, "super_admin")->make()
            )->each(function ($role) {
                // give all the permisson to super admin, config("user.permissions")
                $permissions = config("permissions.user");
                foreach ($permissions as $permission => $description) {
                    $new_permission = new App\Models\Permission();
                    $new_permission->permission = $permission;
                    $new_permission->created_by = 1;

                    $role->permissions()->save($new_permission);
                }
            });
        });
    }
}
