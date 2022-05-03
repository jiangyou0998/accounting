<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Supplier\Supplier;
use App\Models\SupplierGroup;
use App\Models\WarehouseProduct;
use App\Models\WorkshopUnit;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(WarehouseProduct::class, function (Faker $faker) {

    $product_name = $faker->word;

    return [
        'product_name' => $product_name,
        'product_name_short' => $product_name,
        'product_no' => $faker->randomNumber(4, true),
        'barcode' => $faker->randomNumber(7, true),
        //注意randomElement不帶複數才是隨機選一個
        'supplier_id' => $faker->randomElement(Supplier::pluck('id')->toArray()),
        'group_id' => $faker->randomElement(SupplierGroup::pluck('id')->toArray()),
        'unit_id' => $faker->randomElement(WorkshopUnit::pluck('id')->toArray()),
        'base_unit_id' => $faker->randomElement(WorkshopUnit::pluck('id')->toArray()),
        'base_qty' => $faker->randomNumber(3, false),
        'default_price' => $faker->randomFloat(2, 0, 1000),
        'status' => 0,
        'weight' => $faker->randomNumber(3, false),
        'weight_unit' => $faker->randomElement(['斤','包','克']),
        'created_at'  => Carbon::now()->toDateTimeString(),
        'updated_at'  => Carbon::now()->toDateTimeString(),
    ];
});
