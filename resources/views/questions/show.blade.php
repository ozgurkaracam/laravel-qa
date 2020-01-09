@extends('../layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2>{{ $question->title }}</h2>
                                <div class="ml-auto">
                                    <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back To All Questions!</a>
                                </div>
                            </div>
                            <small>Asked By <a href="{{ $question->user->url }}">{{ $question->user->name }}</a> - {{ $question->get_date }}</small>
                        </div>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls mr-3">
                                <a title="This question is useful" class="vote-up">
                                    Vote Up
                                </a>
                                <span class="votes-count">1230</span>
                                <a title="This question is not useful" class="vote-down off">
                                    Vote Down
                                </a>
                                <a title="Click to mark as favorite question (Click again to undo)" class="favorite">
                                    Favorite
                                    <span class="favorites-count">123</span>
                                </a>
                            </div>

                            <div class="media-body">
                                {!! $question->body_html !!}
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                @auth
                                <a href="{{ route('answers.index',$question) }}" class="btn btn-success col-md-6">Reply</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>




                @include('answers.answers',['question'=>$question])
            </div>
        </div>
    </div>
@endsection
