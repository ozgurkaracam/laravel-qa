<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index()
    {
        $questions=Question::latest()->paginate(5);

        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question=new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->User()->Question()->create($request->only('title','body'));

        return redirect()->route('questions.index')->with('success','Your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');

        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if(\Gate::denies('update-question',$question))
            abort(403,"Access denied!");
        return view('questions.edit',compact('question'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title','body'));

        return redirect()->route('questions.index')->with('success','Your question has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Gate::denies('delete-question',Question::query()->find($id))){
            abort(403,'Access Denied!');
          }
        Question::query()->find($id)->delete();
        return redirect()->route('questions.index')->with('success','Your question has been deleted!');

    }

    public function bestanswer(Request $request,Question $question){
        $this->authorize('update',$question);
        $answer=Answer::find($request->answer);
        if($answer->isBest())
            $question->bestAnswer()->dissociate()->save();
        else{
            $question->bestAnswer()->dissociate();
            $question->bestAnswer()->associate($answer)->save();
        }

        return redirect()->back();
    }

    public function favorite($question){
        Question::find($question)->favoritedUsers()->find(Auth::user()) ? Question::find($question)->favoritedUsers()->detach(Auth::user()) : Question::find($question)->favoritedUsers()->attach(Auth::user());
        return redirect()->back();
    }


}


