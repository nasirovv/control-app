<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'name' => 'Isroilov Abdusalom',
           'uniqueId' => '213213sad1'
        ]);

        DB::table('users')->insert([
            'name' => 'Nosirov Mirfayz',
            'uniqueId' => '213213sad1s'
        ]);

        DB::table('users')->insert([
            'name' => 'Azamov Toxirmalik',
            'uniqueId' => '213213sadsda1'
        ]);

        DB::table('users')->insert([
            'name' => 'Asrorova Gulnora',
            'uniqueId' => '21321312sad1'
        ]);
    }
}
