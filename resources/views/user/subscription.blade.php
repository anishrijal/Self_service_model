@extends('layouts.app')

@section('content')
    <div>
        <form action="{{url('/subscribe')}}" method="post" id="subscription-form">
            <span class="payment-errors"></span>
            {!! csrf_field() !!}
            <div>
                付费计划：
                <select name="plan">
                    <option value="silver">银牌会员</option>
                    <option value="gold">金牌会员</option>
                </select>
            </div>
            <div>
                信用卡号：
                <input type="text" name="number" id="number">
            </div>
            <div>
                过期时间：
                月份：<input type="text" name="exp_month" id="exp_month">
                年份：<input type="text" name="exp_year" id="exp_year">
            </div>

            <button type="submit">订购服务</button>
        </form>
    </div>
@endsection
<script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    Stripe.setPublishableKey('{{config("services.stripe.key")}}');
    jQuery(function ($) {
        $('#subscription-form').submit(function (event) {
            var form = $(this);
            form.find('button').prop('disabled', true);
            Stripe.card.createToken({
                number: $('#number').val(),
                exp_month: $('#exp_month').val(),
                exp_year: $('#exp_year').val()
            }, stripeResponseHandler);

            return false;
        });
    });

    var stripeResponseHandler = function (status, response) {
        var form = $('#subscription-form');

        if (response.error) {
            form.find('.payment-errors').text(response.error.message);
            form.find('button').prop('disabled', false);
        } else {
            var token = response.id;
            form.append($('<input type="hidden" name="stripeToken" />').val(token));
            form.get(0).submit();
        }
    };
</script>
