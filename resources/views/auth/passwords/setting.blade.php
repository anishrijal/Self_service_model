

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
                    <input id="settingPassword" type="text" name="password" value="@if(isset(Auth::user()->password)){{old('password',Auth::user()->password)}}@else''@endif"  placeholder="Password" >
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('password')) {{ $errors->first('password') }} @endif
                </div>
                <div>
                    <i class="material-icons">vpn_key</i>
                    <input id="settingPasswordConfirm" type="text" name="password_confirmation" value="@if(isset(Auth::user()->password)){{old('password',Auth::user()->password)}}@else''  @endif" placeholder="Confirm password">
                    <div class="clearfix"></div>
                    <p></p>
                    @if ($errors->has('password_confirmation')) {{ $errors->first('password_confirmation') }} @endif
                </div>
            </div>
            <div class="registerLogin">
                <button id="settingSubmit" type="button">Register</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery-1.9.1.min.js') }}"></script>

    <script>
        $(function(){
            var dW = ($(window).width() - $("#setting-style").width()) / 2;
            var dH = ($(window).height() - $("#setting-style").height()) / 2;
            $("#setting-style").css({left: dW, top: dH});
            //更新资料
            $("#setting-return").on("click",function () {
                $("#LoginText").fadeOut();
                $("#register-style").fadeOut();
                $("#login-style").fadeOut();
                $("#setting").fadeOut();
            });
            $("#settingLastName").blur(function(){
                var text=$(this).parent().find("p");
                if($(this).val() == ""){
                    text.css({display:"block"}).html(" Last Name cannot be empty");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            $("#settingName").blur(function(){
                var text=$(this).parent().find("p");
                if($(this).val() == ""){
                    text.css({display:"block"}).html("Name cannot be empty");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            $("#settingCompany").blur(function(){
                var text=$(this).parent().find("p");
                if($(this).val() == ""){
                    text.css({display:"block"}).html("Company Name cannot be empty");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            $("#settingPhone").blur(function(){
                var text=$(this).parent().find("p");
                if($(this).val() == ""){
                    text.css({display:"block"}).html("Phone number cannot be empty");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            $("#settingEmail").blur(function(){
                var text=$(this).parent().find("p");
                if($(this).val() == ""){
                    text.css({display:"block"}).html("Email  cannot be empty");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            $("#settingPassword").blur(function(){
                var text=$(this).parent().find("p");
                if($(this).val() == ""){
                    text.css({display:"block"}).html("Password  cannot be empty");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            $("#settingPasswordConfirm").blur(function(){
                var password=$("#settingPassword").val();
                var text=$(this).parent().find("p");
                if($(this).val()!=password){
                    text.css({display:"block"}).html("Two passwords are not the same");
                    return false;
                }else {
                    text.css({display:"none"})
                }
            });
            //点击更新资料提交
            $("#settingSubmit").on("click",function(){
                if($("#settingName").val()==""){
                    var text=$("#settingName").parent().find("p");
                    text.css({display:"block"}).html("First Name cannot be empty");
                    return false;
                }
                if($("#settingLastName").val()==""){
                    var text=$("#settingLastName").parent().find("p");
                    text.css({display:"block"}).html("Last Name cannot be empty");
                    return false;
                }
                if($("#settingCompany").val()==""){
                    var text=$("#settingCompany").parent().find("p");
                    text.css({display:"block"}).html("Company Name cannot be empty");
                    return false;
                }
                if($("#settingPhone").val()==""){
                    var text=$("#settingEmail").parent().find("p");
                    text.css({display:"block"}).html("Phone number cannot be empty");
                    return false;
                }
                if($("#settingEmail").val()==""){
                    var text=$("#settingEmail").parent().find("p");
                    text.css({display:"block"}).html("Email cannot be empty");
                    return false;
                }
                if($("#settingPassword").val()==""){
                    var text=$("#settingPassword").parent().find("p");
                    text.css({display:"block"}).html("Password cannot be empty");
                    return false;
                }
                var password=$("#settingPassword").val();
                if($("#settingPasswordConfirm").val()!=password){
                    var text=$("#settingPasswordConfirm").parent().find("p");
                    text.css({display:"block"}).html("Two passwords are not the same");
                    return false;
                }

                $.ajax({
                    url: "/settings",
                    type:"get",
                    dataType:"json",
                    data:$('form').serialize(),
                    headers:{'X-CSRF-TOKEN':$('meta[name="_token"]').attr('content')},
                    success:function(){
                        alert("Modify success");
                        $("#register-style").fadeOut();
                        $("#setting").fadeOut();
                    },
                    error:function(){
                        alert("Failed to load")
                    }
                });
            });

        });
    </script>

