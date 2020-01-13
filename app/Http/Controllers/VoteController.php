<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Answer;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function voteup(Request $request, $type)
    {
        if ($type == 'question') {
            $question = Question::find($request->votequestion);
            if ($question->likedUser()->where('like', 1)->find(Auth::user()) != null)
                $question->likedUser()->detach(Auth::user(), ['like' => 1]);
            else if ($question->likedUser()->where('like', -1)->find(Auth::user()) != null) {
                $question->likedUser()->detach(Auth::user(), ['like' => -1]);
                $question->likedUser()->attach(Auth::user(), ['like' => 1]);
            } else
                $question->likedUser()->attach(Auth::user(), ['like' => 1]);
            return redirect()->back();
        } else if ($type == 'answer') {
            $answer = Answer::find($request->voteanswer);
            if ($answer->likedUser()->where('like', 1)->find(Auth::user()) != null)
                $answer->likedUser()->detach(Auth::user(), ['like' => 1]);
            else if ($answer->likedUser()->where('like', -1)->find(Auth::user()) != null) {
                $answer->likedUser()->detach(Auth::user(), ['like' => -1]);
                $answer->likedUser()->attach(Auth::user(), ['like' => 1]);
            } else
                $answer->likedUser()->attach(Auth::user(), ['like' => 1]);
            return redirect()->back();
        } else {
            abort(404);
        }
    }

    public function votedown(Request $request, $type)
    {
        if ($type == 'question') {
            $question = Question::find($request->votedownquestion);
            if ($question->likedUser()->where('like', -1)->find(Auth::user()) != null)
                $question->likedUser()->detach(Auth::user(), ['like' => -1]);
            else if ($question->likedUser()->where('like', 1)->find(Auth::user()) != null) {
                $question->likedUser()->detach(Auth::user(), ['like' => 1]);
                $question->likedUser()->attach(Auth::user(), ['like' => -1]);
            } else
                $question->likedUser()->attach(Auth::user(), ['like' => -1]);
            return redirect()->back();
        }
        else if ($type == 'answer') {
                $answer = Answer::find($request->voteanswer);
                if ($answer->likedUser()->where('like', -1)->find(Auth::user()) != null)
                    $answer->likedUser()->detach(Auth::user(), ['like' => -1]);
                else if ($answer->likedUser()->where('like', 1)->find(Auth::user()) != null) {
                    $answer->likedUser()->detach(Auth::user(), ['like' => 1]);
                    $answer->likedUser()->attach(Auth::user(), ['like' => -1]);
                } else
                    $answer->likedUser()->attach(Auth::user(), ['like' => -1]);
                return redirect()->back();

        }
        else {
            return abort(404);
        }
    }
}
