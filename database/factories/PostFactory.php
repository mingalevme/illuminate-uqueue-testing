<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->text(),
        'body' => $faker->paragraph(50),
    ];
});
