

<div id="setting">
    <div class="Background-shadow"></div>
    <div id="setting-style">
        <i id="setting-return" class="material-icons character-Close">clear</i>
        <form method="get" action="{{ url('/settings') }}" id="settings">
            {{ csrf_field() }}
            <div class="register-center">

                <div class="register-first">
                    <i class="material-icons">person</i>
                    <input id="settingName" type="text" name="name" value="@if(isset(Auth::user()->name)) {{ old('name',Auth::user()->name) }} @else '' @endif" placeholder="First Name">
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('name')) {{ $errors->first('name') }} @endif
                </div>
                <div class="register-last">
                    <input type="text"  id="settingLastName" name="last_name" value="@if(isset(Auth::user()->last_name)) {{ old('last_name',Auth::user()->last_name) }} @else '' @endif" placeholder="Last Name">
                    <div class="clearfix"></div>
                    <p style="bottom: -34px;"></p>
                    @if ($errors->has('last_name')) {{ $errors->first('last_name') }} @endif
                </div>
                <div class="clearfix"></div>
                <div>
                    <i class="material-icons">work</i>
                    <input id="settingCompany" type="text" name="company" value="@if(isset(Auth::user()->company)) {{ old('company',Auth::user()->company) }} @else '' @endif" placeholder="Company Name">
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('company')) {{ $errors->first('company') }} @endif
                </div>
                <div>
                    <i class="material-icons">phone</i>
                    <input id="settingPhone" type="text" name="phone" value="@if(isset(Auth::user()->phone)) {{ old('phone',Auth::user()->phone) }} @else '' @endif" placeholder="Phone number">
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('company')) {{ $errors->first('company') }} @endif
                </div>
                <div>
                    <i class="material-icons">mail_outline</i>
                    <input id="settingEmail" type="email" name="email" value="@if(isset(Auth::user()->email)) {{ old('email',Auth::user()->email) }} @else '' @endif" placeholder="Email">
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('email')) {{ $errors->first('email') }} @endif
                </div>
                <div>
                    <i class="material-icons">vpn_key</i>
                    <input id="settingPassword" type="password" name="password" value="@if(isset(Auth::user()->password)){{old('password',Auth::user()->password)}}@else''@endif"  placeholder="Password" >
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('password')) {{ $errors->first('password') }} @endif
                </div>
                <div>
                    <i class="material-icons">vpn_key</i>
                    <input id="settingPasswordConfirm" type="password" name="password_confirmation" value="@if(isset(Auth::user()->password)){{old('password',Auth::user()->password)}}@else''  @endif" placeholder="Confirm password">
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('password_confirmation')) {{ $errors->first('password_confirmation') }} @endif
                </div>
            </div>
            <div class="registerLogin">
                <button id="settingSubmit" type="button">Submit</button>
            </div>
        </form>
    </div>
</div>


