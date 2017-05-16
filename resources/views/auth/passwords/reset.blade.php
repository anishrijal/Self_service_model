@extends('layouts.app')

@section('content')
    <div class="register-center">
        <form method="POST" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <img src="{{ asset('image/mailbox.png') }}" alt="">
                <input id="email" type="email" name="email" value="{{ $email or old('email') }}" >
                @if ($errors->has('email')) {{ $errors->first('email') }} @endif
            </div>
            <div>
                <img src="{{ asset('image/password.png') }}" alt="">
                <input id="password" type="password" name="password" placeholder="Please enter a new password">
                @if ($errors->has('password')) {{ $errors->first('password') }} @endif
            </div>
            <div>
                <img src="{{ asset('image/password.png') }}" alt="">
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="Please confirm your new password">
                @if ($errors->has('password_confirmation')) {{ $errors->first('password_confirmation') }} @endif
            </div>
            <button type="submit"> Reset Password</button>
        </form>
    </div>

@endsection
