<?php

use App\Models\PurchaseOrder;
use Faker\Generator as Faker;

$factory->define(PurchaseOrder::class, function (Faker $faker) {
    return [
        'buyer'         => $faker->name(),
        'supplier'      => $faker->name(),
        'total_cost'    => $faker->randomFloat(2, 5000, 25000), // 2 decimal points, ranged from 5,000 to 25,000
        'breakdown'     => $faker->sentence,
        'purpose'       => $faker->sentence
    ];
});
