<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        State::insert([
            ['name'=>'서울특별시', 'created_at' => now(), 'updated_at' => now(),],        //1
            ['name'=>'부산광역시', 'created_at' => now(), 'updated_at' => now(),],        //2
            ['name'=>'대구광역시', 'created_at' => now(), 'updated_at' => now(),],        //3
            ['name'=>'인천광역시', 'created_at' => now(), 'updated_at' => now(),],        //4
            ['name'=>'광주광역시', 'created_at' => now(), 'updated_at' => now(),],        //5
            ['name'=>'대전광역시', 'created_at' => now(), 'updated_at' => now(),],        //6
            ['name'=>'울산광역시', 'created_at' => now(), 'updated_at' => now(),],        //7
            ['name'=>'세종특별자치시', 'created_at' => now(), 'updated_at' => now(),],    //8
            ['name'=>'경기도', 'created_at' => now(), 'updated_at' => now(),],            //9
            ['name'=>'강원특별자치도', 'created_at' => now(), 'updated_at' => now(),],            //10
            ['name'=>'충청북도', 'created_at' => now(), 'updated_at' => now(),],          //11 V
            ['name'=>'충청남도', 'created_at' => now(), 'updated_at' => now(),],          //12
            ['name'=>'전북특별자치도', 'created_at' => now(), 'updated_at' => now(),],          //13
            ['name'=>'전라남도', 'created_at' => now(), 'updated_at' => now(),],          //14
            ['name'=>'경상북도', 'created_at' => now(), 'updated_at' => now(),],          //15 V
            ['name'=>'경상남도', 'created_at' => now(), 'updated_at' => now(),],          //16
            ['name'=>'제주특별자치도', 'created_at' => now(), 'updated_at' => now(),],    //17
        ]);
    }
}