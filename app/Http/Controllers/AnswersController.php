<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        $this->middleware('auth');
        return view('answers.create',['question'=>$question]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Question $question)
    {
        $question->answers()->create(
            [
                'text'=>$request->body,
                'user_id'=> Auth::id()
            ]
        )->save();

//        return view('questions.show',[
//            'question'=>$question,
//            'success'=>'success'
//        ]);
        return redirect()->route('questions.show',$question->slug)->with('success','Answered Successfull!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question,Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);
        return view('answers.edit',['question'=>$question,'answer'=>$answer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question, Answer $answer)
    {
        $this->authorize('update',$answer);
        $answer->text=$request->body;
        $answer->save();


        return redirect()->route('questions.show',$question->slug)->with('success','Answer Update Successfull!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete',$answer);
        Answer::destroy($answer->id);

        return redirect()->route('questions.show',$question->slug)->with('success','Your answer deleted!!');
    }
    public function favorite($answer){
        Answer::find($answer)->favoritedUsers()->find(Auth::user()) ? Answer::find($answer)->favoritedUsers()->detach(Auth::user()) : Answer::find($answer)->favoritedUsers()->attach(Auth::user());
        return redirect()->back();
    }
}
