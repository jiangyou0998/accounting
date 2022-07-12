<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseProductPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Models\WarehouseProduct::all();

        foreach ($products as $product){

            $now = \Carbon\Carbon::now();
            $base_price = rand(1,50);
            $price = $base_price * $product->base_qty;
            DB::table('warehouse_product_prices')->insert([
                'price' => $price,
                'base_price' => $base_price,
                'product_id' => $product->id,
                'sort' => 1,
                'start_date' => '2022-06-01',
                'end_date' => '9999-12-31',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
