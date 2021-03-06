<div class="card mt-4">
    <div class="card-header">
        {{--                        <div class="d-flex align-items-center">--}}
        {{--                            <h2>{{ $question->title }}</h2>--}}
        {{--                            <div class="ml-auto">--}}
        {{--                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back To All Questions!</a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <smal>Asked By <a href="{{ $question->user->url }}">{{ $question->user->name }}</a> - {{ $question->get_date }}</smal>--}}
        <h1>{{$question->answers->count()}} Answers</h1>
    </div>
    <div class="card-body">

        @include('layouts._messages')
        
        @foreach($question->answers as $answer)
            <div class="media">

                <form action="{{ route('questions.bestanswer',$answer->question) }}" id="selectbest{{$answer->id}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="answer" value="{{ $answer->id }}">
                </form>
                @if($answer->isBest())
                    <div class="m-auto" style="cursor: pointer">
                        <i class="fas fa-check fa-3x" onclick="getElementById('selectbest{{$answer->id}}').submit()" @if($answer->isBest())style="color: limegreen" @endif></i>
                    </div>
                @else
                @can('update',$answer->question)
                <div class="m-auto" style="cursor: pointer">
                    <i class="fas fa-check fa-3x" onclick="getElementById('selectbest{{$answer->id}}').submit()" @if($answer->isBest())style="color: limegreen" @endif></i>
                </div>
                @endcan
                @endif
                <div class="d-flex flex-column vote-controls mr-4 text-center">
                    <form action="{{ route('voteup','answer') }}" method="POST" id="voteupanswer{{$answer->id}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="voteanswer" value="{{ $answer->id }}">
                    </form>
                    <a title="This question is useful" class="vote-up">
                        <i class="fas fa-caret-up fa-5x" onclick="document.getElementById('voteupanswer{{$answer->id}}').submit()" style="cursor:pointer; @if(\Illuminate\Support\Facades\Auth::user() && $answer->likedUser()->where('like',1)->find(\Illuminate\Support\Facades\Auth::user())) color:greenyellow @endif" ></i>
                    </a>
                    <span class="votes-count">{{ $answer->likedUser()->sum('like') }}</span>
                    <form action="{{ route('votedown','answer') }}" method="POST" id="votedownanswer{{$answer->id}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="voteanswer" value="{{ $answer->id }}">
                    </form>
                    <a title="This question is not useful" class="vote-down off">
                        <i class="fas fa-caret-down fa-5x" onclick="document.getElementById('votedownanswer{{$answer->id}}').submit()"  style="@if(\Illuminate\Support\Facades\Auth::user() && $answer->likedUser()->where('like',-1)->find(\Illuminate\Support\Facades\Auth::user())) color:red; @endif cursor:pointer"></i>
                    </a>
                    <a title="Click to mark as favorite question (Click again to undo)" onclick="document.getElementById('favorite{{$answer->id}}').submit()" class="favorite">
                        <i class="fas fa-star fa-2x" @auth onclick="" @endauth style="@auth cursor:pointer; @endauth @if(\Illuminate\Support\Facades\Auth::user() && $answer->favoritedUsers()->find(\Illuminate\Support\Facades\Auth::user()))color: orange @endif"></i>
                        <span class="favorites-count">{{ $answer->favoritedUsers()->count() }}</span>
                        <form action="{{ route('answers.favorite',$answer) }}" id="favorite{{$answer->id}}" method="post">
                            {{ csrf_field() }}
                        </form>
                    </a>

                </div>
                <div class="media-body">
                    @can('update',$answer)
                        <a href="{{ route('answers.edit',[$question,$answer]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                       @endcan
                        @can('delete',$answer)
                    <form action="{{ route('answers.destroy',[$question,$answer]) }}" method="post" class="form-delete">

                        @method('DELETE',$answer)
                        @csrf
                        <input type="submit" class="btn btn-sm btn-outline-danger" value="Delete"> </input>
                    </form>
                    @endcan
                    {!! $answer->body_html !!}

                    <div class="float-right">
                        <span class="text-muted">{{ $answer->date }}</span>
                        <div class="media">
                            <a href="{{ $answer->user->url }}" class="pr-2">
                                <img src="{{ $answer->user->avatar }}" alt="">
                            </a>
                            <div class="media-body mt-2">
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
