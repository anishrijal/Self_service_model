
<i id="register-return" class="material-icons character-Close">clear</i>
<form method="POST" action="{{ url('/register') }}" id="register">
    {{ csrf_field() }}
    <div class="register-center">

        <div class="register-first">
            <i class="material-icons">person</i>
            <input  id="registerName" type="text" name="name" value="{{ old('name') }}" placeholder=" First Name">
            <div class="clearfix"></div>
            <p></p>
            @if ($errors->has('name')) {{ $errors->first('name') }} @endif
        </div>
        <div class="register-last">
            <input id="registerLastName" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
            <div class="clearfix"></div>
            <p style="bottom: -34px;"></p>
            @if ($errors->has('last_name')) {{ $errors->first('last_name') }} @endif
        </div>
        <div class="clearfix"></div>
        <div>
            <i class="material-icons">work</i>
            <input id="registerCompany" type="text" name="company" value="{{ old('last_name') }}" placeholder="Company Name">
            <div class="clearfix"></div>
            <p></p>
            @if ($errors->has('company')) {{ $errors->first('company') }} @endif
        </div>
        <div>
            <i class="material-icons">phone</i>
            <input id="registerPhone" type="text" name="phone" value="{{ old('Phone') }}" placeholder="Phone number">
            <div class="clearfix"></div>
            <p></p>
            @if ($errors->has('company')) {{ $errors->first('company') }} @endif
        </div>
        <div>
            <i class="material-icons">mail_outline</i>
            <input id="registerEmail" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
            <div class="clearfix"></div>
            <p></p>
            @if ($errors->has('email')) {{ $errors->first('email') }} @endif
        </div>
        <div>
            <i class="material-icons">vpn_key</i>
            <input id="registerPassword" type="password" name="password" placeholder="Password">
            <div class="clearfix"></div>
            <p></p>
            @if ($errors->has('password')) {{ $errors->first('password') }} @endif
        </div>
        <div>
            <i class="material-icons">vpn_key</i>
            <input id="registerPasswordConfirm" type="password" name="password_confirmation"
                   placeholder="Confirm password">
            <div class="clearfix"></div>
            <p></p>
            @if ($errors->has('password_confirmation')) {{ $errors->first('password_confirmation') }} @endif
        </div>
    </div>
    <p id="Prompt-login"><input  class="Agreement" type="checkbox" name="checkboxs">I agree to the <span>Terms of Service</span></p>
    <div class="registerLogin">
        <button id="registerSubmit" type="button">Register</button>
        <span>Login instead</span>
    </div>
</form>
@section('content')

@endsection
