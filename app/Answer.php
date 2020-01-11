<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable=['text','user_id'];
    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likedUser(){
        return $this->morphToMany(User::class,'likable','questionlikes','likable_id','user_id');
    }
    public function favoritedUsers(){
        return $this->morphToMany(User::class,'fav','favorites','fav_id','user_id');
    }

    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->text);
    }

    public function getDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::created(function($answer){
            $answer->question->increment('answers_count');
            $answer->question->save();
        });
    }

    public function isBest(){
        $q=new Question();
        $q=$this->question;
        return $q->best_answer_id===$this->id;
    }

}
