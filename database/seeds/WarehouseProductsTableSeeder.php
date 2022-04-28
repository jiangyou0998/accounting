<?php

use Illuminate\Database\Seeder;

class WarehouseProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = factory(\App\Models\WarehouseProduct::class, 1000)->make();
        \App\Models\WarehouseProduct::insert($products->toArray());
    }
}
