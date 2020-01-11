<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=0;$i<100;$i++){
            $user=User::get()->random();
            $answer=Answer::get()->random();
            if(!$user->likeAnswers()->find($answer)==null)
                $user->likeAnswers()->attach($answer,['like'=>[-1,1][rand(0,1)]]);
        }

//        for($i=0;$i<100;$i++)
//            User::get()->random()->likeQuestions()->attach(Question::get()->random(),['like'=>[-1,1][rand(0,1)]]);
    }
}
