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
                            <div class="d-flex flex-column vote-controls mr-3 text-center">
                                <form action="{{ route('voteup','question') }}" method="POST" id="voteupquestion">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="votequestion" value="{{ $question->id }}">
                                </form>
                                <a title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-5x" style="cursor:pointer; @if(\Illuminate\Support\Facades\Auth::user() && $question->likedUser()->where('like',1)->find(\Illuminate\Support\Facades\Auth::user()))color:greenyellow;@endif" onclick="document.getElementById('voteupquestion').submit()"></i>
                                </a>
                                <span class="votes-count d-block">{{ $question->likedUser()->sum('like') }}</span>
                                <form action="{{ route('votedown','question') }}" method="POST" id="votedownquestion">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="votedownquestion" value="{{ $question->id }}">
                                </form>
                                <a title="This question is not useful" class="vote-down off" style="cursor:pointer; @if(\Illuminate\Support\Facades\Auth::user() && $question->likedUser()->where('like',-1)->find(\Illuminate\Support\Facades\Auth::user()))color:red;@endif" onclick="document.getElementById('votedownquestion').submit()">
                                    <i class="fas fa-caret-down fa-5x"></i>
                                </a>
                                <a title="Click to mark as favorite question (Click again to undo)" class="favorite" @auth onclick="document.getElementById('favorite').submit()" @endauth style="@auth cursor:pointer; @endauth">
                                    <i class="fas fa-star fa-2x" @if(\Illuminate\Support\Facades\Auth::user() && $question->favoritedUsers()->find(\Illuminate\Support\Facades\Auth::user()))style="color:orange"@endif></i>
                                    <span class="favorites-count">{{ $question->favoritedUsers()->count() }}</span>
                                    <form action="{{ route('questions.favorite',$question) }}" id="favorite" method="post">
                                        {{ csrf_field() }}
                                    </form>
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
