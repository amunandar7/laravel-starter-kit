<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User,
    App\Role,
    App\Permission;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * create permissions
         */
        $viewExampleCategory = new Permission();
        $viewExampleCategory->name = "view-example-category";
        $viewExampleCategory->display_name = "View Example Category";
        $viewExampleCategory->save();

        $createExampleCategory = new Permission();
        $createExampleCategory->name = "create-example-category";
        $createExampleCategory->display_name = "Create Example Category";
        $createExampleCategory->save();

        $editExampleCategory = new Permission();
        $editExampleCategory->name = "edit-example-category";
        $editExampleCategory->display_name = "Edit Example Category";
        $editExampleCategory->save();
        $createExampleCategory->save();

        $deleteExampleCategory = new Permission();
        $deleteExampleCategory->name = "delete-example-category";
        $deleteExampleCategory->display_name = "Delete Example Category";
        $deleteExampleCategory->save();

        $viewExample = new Permission();
        $viewExample->name = "view-example";
        $viewExample->display_name = "View Example";
        $viewExample->save();

        $createExample = new Permission();
        $createExample->name = "create-example";
        $createExample->display_name = "Create Example";
        $createExample->save();

        $editExample = new Permission();
        $editExample->name = "edit-example";
        $editExample->display_name = "Edit Example";
        $editExample->save();

        $deleteExample = new Permission();
        $deleteExample->name = "delete-example";
        $deleteExample->display_name = "Delete Example";
        $deleteExample->save();

        $viewUser = new Permission();
        $viewUser->name = "view-user";
        $viewUser->display_name = "View User";
        $viewUser->save();

        $createUser = new Permission();
        $createUser->name = "create-user";
        $createUser->display_name = "Create User";
        $createUser->save();

        $editUser = new Permission();
        $editUser->name = "edit-user";
        $editUser->display_name = "Edit User";
        $editUser->save();

        $deleteUser = new Permission();
        $deleteUser->name = "delete-user";
        $deleteUser->display_name = "Delete User";
        $deleteUser->save();

        /**
         * create role & users super admin
         */
        $superadmin = new Role();
        $superadmin->name = "superadmin";
        $superadmin->display_name = "Super Admin";
        $superadmin->save();
        $superadmin->attachPermissions([$viewExampleCategory, $createExampleCategory, $editExampleCategory, $deleteExampleCategory, $viewExample, $createExample, $editExample, $deleteExample, $viewUser, $createUser, $editUser, $deleteUser]);


        $user = new User();
        $user->name = "Super Admin";
        $user->email = "superadmin@example.com";
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->password = bcrypt('superadmin');
        $user->save();
        $user->attachRole($superadmin);
        $deleteExample->save();

        /**
         * create role & users admin
         */
        $admin = new Role();
        $admin->name = "admin";
        $admin->display_name = "Admin";
        $admin->save();
        $admin->attachPermissions([$viewExampleCategory, $createExampleCategory, $editExampleCategory, $viewExample, $createExample, $editExample]);


        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@example.com";
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->password = bcrypt('admin');
        $user->save();
        $user->attachRole($admin);
    }
}
