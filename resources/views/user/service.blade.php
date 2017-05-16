@extends('layouts.app')

@section('content')
    <div>
        <form action="{{url('/payment')}}" method="post" autocomplete="off">
            {{ csrf_field() }}
            <label for="item">
                产品名称
                <input type="text" name="product" value="">
            </label>
            <br>
            <label for="amount">
                价格
                <input type="text" name="price" value="">
            </label>
            <br>
            <input type="submit" value="去付款">
        </form>
    </div>
@endsection