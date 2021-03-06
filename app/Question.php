<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Question extends Model
{
    protected $fillable=['title','body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function likedUser(){
        return $this->morphToMany('App\User','likable','questionlikes','likable_id','user_id')->withPivot('like');
    }
    public function favoritedUsers(){
        return $this->morphToMany(User::class,'fav','favorites','fav_id','user_id');
    }

    public function  setTitleAttribute($value){
        $this->attributes['title']=$value;
        $this->attributes['slug']=Str::slug($value);
    }

    public function getGetDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getUrlAttribute(){
        return route('questions.show',$this->slug);
    }
    public function getStatusAttribute(){
        if($this->answers_count >0){
            if($this->best_answer_id)
                return "answered-accepted";
            return "answered";
        }
        return "unanswered";

    }

    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
    }

    public function bestAnswer(){
            return $this->belongsTo(Answer::class,'best_answer_id','id');
    }

}
