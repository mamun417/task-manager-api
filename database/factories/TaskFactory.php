<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::all()->random(1)->first()->id, // user
        'title' => $faker->sentence(10),
        'description' => $faker->text,
        'due_date' => $faker->dateTime,
        'created_at' => $faker->dateTime
    ];
});
