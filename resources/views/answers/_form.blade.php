@csrf

<div class="form-group">
    <label for="answer-body">Answer This Question!</label>
    <textarea name="body" id="answer-body"  rows="10" class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}">{{ Old('body') }}</textarea>
    @if($errors->has('body'))
        <div class="invalid-feedback">
            <strong>{{$errors->first('body')}}</strong>
        </div>
    @endif
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary btn-lg">{{ $buttonText }}</button>
</div>
