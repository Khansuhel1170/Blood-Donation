<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BloodBankInventory;

class BloodBankInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BloodBankInventory::factory()->count(50)->create();
    }
}
