@extends('layouts.app')

@section('content')
<div class="form-box">
    <div class="form-value">
        <form action="{{ route('login') }}" method="POST"> @csrf
            <h2>Авторизация</h2>
                <x-form.input id="email" type="email" name="email">Почта</x-form.input>
                <x-form.input id="password" type="password" name="password">Пароль:</x-form.input>
            <div class="forget">
                <label for=""><input type="checkbox">Запомнить<a href="#">, забыли пароль?</a></label>
            </div>
            <button type="submit">Войти</button>
            <div class="register-box">
                <p> <a href="{{ route('register') }}">Зарегистрироваться</a></p>
            </div>
        </form>
    </div>
</div>

@endsection
