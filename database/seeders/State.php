<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\States;
use App\Models\Districts;
use App\Models\Cities;

class State extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        States::factory(10)->has(Districts::factory()->count(5)->has(Cities::factory()->count(5)))->create();
    }
}
