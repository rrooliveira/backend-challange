<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert(
            [
                'user_id' => 1,
                'balance' => '1000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 2,
                'balance' => '2000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 3,
                'balance' => '3000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 4,
                'balance' => '4000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 5,
                'balance' => '5000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 6,
                'balance' => '6000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 7,
                'balance' => '7000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 8,
                'balance' => '8000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 9,
                'balance' => '9000.00',
            ]
        );

        DB::table('wallets')->insert(
            [
                'user_id' => 10,
                'balance' => '10000.00',
            ]
        );
    }
}
