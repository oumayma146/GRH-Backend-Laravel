<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[
            \Spatie\Permission\PermissionRegistrar::class
        ]->forgetCachedPermissions();
/*
        // create permissions
        $arrayOfPermissionNames = [
            // Posts
            "access posts",
            "create posts",
            "update posts",
            "delete posts",
             // Salaire
            "access salaire",
            "create salaire",
            "update salaire",
            "delete salaire",
             // Formation
            "access formation",
            "create formation",
            "update formation",
            "delete formation",
             // Congée
            "access congee",
            "create congee",
            "update congee",
            "delete congee",
            // Annonce
            "access annonce",
            "create annonce",
            "update annonce",
            "delete annonce",   
            // Users
            "access users",
            "create users",
            "update users",
            "delete users",
            // ....
        ];
        $permissions = collect($arrayOfPermissionNames)->map(function (
            $permission
        ) {
            return ["name" => $permission, "guard_name" => "web"];
        });

        Permission::insert($permissions->toArray());*/

        // create role & give it permissions
        $title = "Répresentant Commercial";
        $slug = Str::slug($title);
        Role::create(["name" => $title,"slug"=>$slug])->givePermissionTo(["access formation", "create formation","update formation","delete formation"]);
        /*Role::create(["name" => "admin"])->givePermissionTo(Permission::all());
        Role::create(["name" => "RH"])->givePermissionTo(["access salaire","create salaire","update formation",  "update salaire",
        "delete salaire", "access formation", "create formation","update formation","delete formation", "access congee", "create congee",
        "update congee","delete congee", "access annonce","create annonce", "update annonce","delete annonce",]);*/
    
      // Assign roles to users (in this case for user id -> 1 & 2)
      /*User::find(1)->assignRole('admin');
      User::find(2)->assignRole('RH');*/
    }
}
