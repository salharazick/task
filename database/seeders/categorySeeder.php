<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([

            [
                'name'=> 'Tv',               
            ],

            [
                'name'=> 'camera',    
            ],

            [
                'name' => 'mp3 player'
            ],

            [
                'name'=> 'mobile',    
            ],

        ]);
    }
}
