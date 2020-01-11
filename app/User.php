<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Question(){
        return $this->hasMany(Question::class);
    }

    public function answer(){
        return $this->hasMany(Answer::class);
    }

    public function likes(){
        return $this->morphedByMany('\App\Question','likable','questionlikes','user_id','likable_id')->withPivot('like');
    }

    public function favoriteAnswers(){
        return $this->morphedByMany(Answer::class,'fav','favorites','user_id','fav_id');
    }
    public function favoriteQuestions(){
        return $this->morphedByMany(Question::class,'fav','favorites','user_id','fav_id');
    }

    public function getGetDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getUrlAttribute(){
        return '#';
    }

    public function getAvatarAttribute(){
        $email = $this->email;
        $size = 35;

        return "https://www.gravatar.com/avatar/?s=" . $size;

    }

}
