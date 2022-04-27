<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
          
            [
                "name" => "Munafio",
                "email" => "info@munafio.com",
                "password" => "11223344",
                "prenom" => "aaa",
                "adresse" => "tunis",
                "statu" => "marié",
                "genre" => "femme",
            ], 
             [
                "name" => "Ahmed",
                "email" => "rh@email.com",
                "password" => "123456",
                "prenom" => "aaa",
                "adresse" => "tunis",
                "statu" => "marié",
                "genre" => "homme",
            ], 

          
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}

