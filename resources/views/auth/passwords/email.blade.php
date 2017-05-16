

<form id="forgetSubmit" method="POST" action="{{ url('/password/email') }}">
    {{ csrf_field() }}
    <div class="register-center forgetCenter">
        <i id="forget-return" class="material-icons character-Close">clear</i>
        <div>
            <i class="material-icons">mail_outline</i>
            <input id="forgetEmail" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Please enter your email address">
            @if ($errors->has('email'))
                <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif
            <p class="forgetPrompt"></p>
        </div>

    </div>
    <div class="modify-foot">
        <button type="button" id="modifyPassword">Retset password</button>
    </div>
</form>
    @section('content')
@endsection
