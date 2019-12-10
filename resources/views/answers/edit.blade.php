@extends('../layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Answer</h2><small class="text-info ml-5 pr-3">{{ $question->body }}</small>
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back to All Questions</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('answers.update',$question->answer) }}" method="post">
                            @method('UPDATE')
                            @include('answers._form',['buttonText'=>"Edit!",'answer'=>$question->answer])
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('answers.answers',['question'=>$question])
    </div>
@endsection
