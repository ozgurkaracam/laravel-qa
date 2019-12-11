<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id'=> rand(1,3),
        'text'=>$faker->paragraphs(rand(1,5),true),
        'vote_count'=>rand(-3,10)

    ];
});
