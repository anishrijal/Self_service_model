
    <i id="login-return" class="material-icons character-Close">clear</i>
    <form method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="register-center">
            <div>
                <i class="material-icons">person</i>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Username">
                <div class="clearfix"></div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div>
                <i class="material-icons">vpn_key</i>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                <div class="clearfix"></div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="login-foot">
            <button type="submit" id="login">Login</button>
            <a id="retrieve">Forget password</a>
        </div>
    </form>
    @section('content')
@endsection
