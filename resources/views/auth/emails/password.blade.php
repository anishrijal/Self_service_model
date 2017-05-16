
<div style="width: 650px;height: auto;margin: 30px auto;">
    <div  style=" background-color: #f1f1f1;">
        <img src="{{ asset('image/logo.png') }}" alt="">
    </div>
    <h1 style="font-size: 18px;color: #000;margin: 30px 0;">尊敬的用户你好:</h1>
    <p style="font-size: 14px;color: #000;margin-top: 20px;">Vmaxx提醒你请及时修改你的密码:</p>
    <a style="margin-top: 20px;font-size: 16px; color: red;" href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">点击链接即可进入修改密码</a>
    <p style="font-size: 14px;color: #000;margin-top: 20px;">为保障您的帐号安全，请在24小时内点击该链接，您也可以将链接复制到浏览器地址栏访问。 若如果您并未尝试修改密码，请忽略本邮件，由此给您带来的不便请谅解</p>
    <p style="font-size: 14px;color: #000;margin-top: 50px;">本邮件由系统自动发出，请勿直接回复</p>
</div>