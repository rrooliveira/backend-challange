<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameMale . ' ' . $faker->lastName,
                'email' => 'customer1@gmail.com',
                'password' => Hash::make('password'),
                'document' => '111.111.111-11',
                'type_user' => 'C'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameFemale . ' ' . $faker->lastName,
                'email' => 'customer2@gmail.com',
                'password' => Hash::make('password'),
                'document' => '222.222.222-22',
                'type_user' => 'C'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameMale . ' ' . $faker->lastName,
                'email' => 'customer3@gmail.com',
                'password' => Hash::make('password'),
                'document' => '333.333.333-33',
                'type_user' => 'C'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameFemale . ' ' . $faker->lastName,
                'email' => 'customer4@gmail.com',
                'password' => Hash::make('password'),
                'document' => '444.444.444-44',
                'type_user' => 'C'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameMale . ' ' . $faker->lastName,
                'email' => 'customer5@gmail.com',
                'password' => Hash::make('password'),
                'document' => '555.555.555-55',
                'type_user' => 'C'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->company,
                'email' => 'shopkeeper1@gmail.com',
                'password' => Hash::make('password'),
                'document' => '11.111.111/1111-11',
                'type_user' => 'S'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->company,
                'email' => 'shopkeeper2@gmail.com',
                'password' => Hash::make('password'),
                'document' => '22.222.222/2222-22',
                'type_user' => 'S'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->company,
                'email' => 'shopkeeper3@gmail.com',
                'password' => Hash::make('password'),
                'document' => '33.333.333/3333-33',
                'type_user' => 'S'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->company,
                'email' => 'shopkeeper4@gmail.com',
                'password' => Hash::make('password'),
                'document' => '44.444.444/4444-44',
                'type_user' => 'S'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->company,
                'email' => 'shopkeeper5@gmail.com',
                'password' => Hash::make('password'),
                'document' => '55.555.555/5555-55',
                'type_user' => 'S'
            ]
        );
    }
}
