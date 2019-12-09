@extends('../layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>{{ $question->title }}</h2>
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back To All Questions!</a>
                            </div>
                        </div>
                        <small>Asked By <a href="{{ $question->user->url }}">{{ $question->user->name }}</a> - {{ $question->get_date }}</small>
                    </div>
                    <div class="card-body">
                        {!! $question->body_html !!}
                    </div>
                </div>




                <div class="card mt-4">
                    <div class="card-header">
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <h2>{{ $question->title }}</h2>--}}
{{--                            <div class="ml-auto">--}}
{{--                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back To All Questions!</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <smal>Asked By <a href="{{ $question->user->url }}">{{ $question->user->name }}</a> - {{ $question->get_date }}</smal>--}}
                        <h1>{{$question->answers_count}} Answers</h1>
                    </div>
                    <div class="card-body">
                        @foreach($question->answers as $answer)
                        <div class="media">
                            <div class="media-body">
                                {!! $answer->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">{{ $answer->date }}</span>
                                    <div class="media">
                                        <a href="{{ $answer->user->url }}" class="pr-2">
                                            <img src="{{ $answer->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-4">
                                            <a href="{{ $answer->user->url }}"> {{ $answer->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <hr>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
