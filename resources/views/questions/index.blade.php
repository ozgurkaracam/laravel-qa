@extends('../layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>All Questions</h2>
                            @auth
                            <div class="ml-auto">
                                <a href="{{route('questions.create')}}" class="btn btn-outline-secondary">Ask Question!</a>
                            </div>
                            @endauth
                        </div>
                    </div>

                    <div class="card-body">
                        @include('layouts._messages')
                       @foreach($questions as $question)
                           <div class="media">
                               <div class="d-flex flex-column counters">
                                   <div class="vote">
                                       <strong>{{$question->votes}}</strong> {{Str::plural('vote',$question->votes)}}
                                   </div>
                                   <div class="status {{$question->status}}">
                                       <strong>{{$question->answers_count}}</strong> {{Str::plural('answer',$question->votes)}}
                                   </div>
                                   <div class="view">
                                       <strong>{{$question->views}}</strong> {{Str::plural('view',$question->votes)}}
                               </div>

                               </div>
                               <div class="media-body">

                                   <div class="d-flex align-items-center">

                                       <a href="{{$question->url}}">{{$question->title}}</a>

                                       <div class="ml-auto">
                                           @if(\Illuminate\Support\Facades\Auth::user())
                                           @if(\Illuminate\Support\Facades\Auth::user()->can('update-question',$question))
                                           <a href="{{ route('questions.edit',$question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                           @endif
                                           @if(\Illuminate\Support\Facades\Auth::user()->can('delete-question',$question))
                                           <form class="form-delete" action="{{ route('questions.destroy',$question->id) }}" method="post">
                                               @method('DELETE')
                                               @csrf
                                               <input type="submit" value="Delete" class="btn btn-sm btn-outline-danger">
                                           </form>
                                            @endif
                                           @endif


                                       </div>

                                   </div>
                                   <p class="lead">Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a> <small class="text-muted"> {{$question->get_date}} </small> </p>
                                   <h3 class="mt-0">


                                   </h3>
                                   {{Str::limit($question->body,250)}}
                               </div>
                           </div>
                            <hr>
                           @endforeach

                        {{$questions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
