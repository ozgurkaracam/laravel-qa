<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('questions.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/vote/voteup/{type}','VoteController@voteup')->name('voteup');
Route::post('/vote/votedown/{type}','VoteController@votedown')->name('votedown');
Route::post('/questions/{question}/bestanswer/','QuestionsController@bestanswer')->name('questions.bestanswer');
Route::post('/questions/{question}/favorited','QuestionsController@favorite')->name('questions.favorite');
Route::resource('/questions','QuestionsController')->except('show');
Route::get('/questions/{slug}','QuestionsController@show')->name('questions.show');
Route::post('/answers/{answer}/favorited','AnswersController@favorite')->name('answers.favorite');
Route::resource('/questions/{question}/answers','AnswersController');
