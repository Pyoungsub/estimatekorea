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
            ['state_name'=>'서울특별시', 'created_at' => now(), 'updated_at' => now(),],        //1
            ['state_name'=>'부산광역시', 'created_at' => now(), 'updated_at' => now(),],        //2
            ['state_name'=>'대구광역시', 'created_at' => now(), 'updated_at' => now(),],        //3
            ['state_name'=>'인천광역시', 'created_at' => now(), 'updated_at' => now(),],        //4
            ['state_name'=>'광주광역시', 'created_at' => now(), 'updated_at' => now(),],        //5
            ['state_name'=>'대전광역시', 'created_at' => now(), 'updated_at' => now(),],        //6
            ['state_name'=>'울산광역시', 'created_at' => now(), 'updated_at' => now(),],        //7
            ['state_name'=>'세종특별자치시', 'created_at' => now(), 'updated_at' => now(),],    //8
            ['state_name'=>'경기도', 'created_at' => now(), 'updated_at' => now(),],            //9
            ['state_name'=>'강원특별자치도', 'created_at' => now(), 'updated_at' => now(),],            //10
            ['state_name'=>'충청북도', 'created_at' => now(), 'updated_at' => now(),],          //11 V
            ['state_name'=>'충청남도', 'created_at' => now(), 'updated_at' => now(),],          //12
            ['state_name'=>'전북특별자치도', 'created_at' => now(), 'updated_at' => now(),],          //13
            ['state_name'=>'전라남도', 'created_at' => now(), 'updated_at' => now(),],          //14
            ['state_name'=>'경상북도', 'created_at' => now(), 'updated_at' => now(),],          //15 V
            ['state_name'=>'경상남도', 'created_at' => now(), 'updated_at' => now(),],          //16
            ['state_name'=>'제주특별자치도', 'created_at' => now(), 'updated_at' => now(),],    //17
        ]);
    }
}