<?php

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answercount=Answer::all()->count();
        $questioncount=Question::all()->count();
        for($i=0;$i<rand(50,200);$i++){
            User::find(rand(1,4))->favoriteAnswers()->attach(Answer::all()->random());
        }
//        for($i=0;$i<rand(50,200);$i++){
//            User::find(rand(1,4))->favoriteQuestions()->attach(Question::find(rand(1,$questioncount)));
//        }

    }
}
