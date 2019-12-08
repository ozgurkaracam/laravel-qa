@extends('../layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">All Questions</div>

                    <div class="card-body">
                       @foreach($questions as $question)
                           <div class="media">
                               <div class="d-flex flex-column counters">
                                   <div class="vote">
                                       <strong>{{$question->votes}}</strong> {{Str::plural('vote',$question->votes)}}
                                   </div>
                                   <div class="status {{$question->status}}">
                                       <strong>{{$question->answers}}</strong> {{Str::plural('answer',$question->votes)}}
                                   </div>
                                   <div class="view">
                                       <strong>{{$question->views}}</strong> {{Str::plural('view',$question->votes)}}
                               </div>

                               </div>
                               <div class="media-body">
                                   <p class="lead">Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a> <small class="text-muted"> {{$question->get_date}} </small> </p>
                                   <h3 class="mt-0">
                                       <a href="{{$question->url}}">{{$question->title}}</a>

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
