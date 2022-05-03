<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WarehouseProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = factory(\App\Models\WarehouseProduct::class)->times(1000)->make();
        \App\Models\WarehouseProduct::insert($products->toArray());
    }
}
