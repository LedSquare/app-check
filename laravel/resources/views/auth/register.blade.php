@extends('layouts.app')

@section('content')
    <div class="form-box">
        <div class="form-value">
            <form action="{{ route('register') }}" method="post">
                <h2>Регистрация</h2>
                <x-form.input id="username" type="text" name="username" required>Логин</x-form.input>
                <x-form.input id="email" type="email" name="email" required>Почта</x-form.input>
                {{-- TODO: Решить вопрос с маской --}}
                {{-- <vue-phone-input> </vue-phone-input> --}}
                <x-form.input id="phone" type="text" name="phone">Телефон</x-form.input>
                <x-form.input id="password" type="text" name="password" required>Пароль</x-form.input>
                <x-form.input id="password_confirmation" type="text" name="password_confirmation" required>Подтверждение
                    пароля</x-form.input>
                <x-form.input id="firstname" type="text" name="firstname" required>Имя</x-form.input>
                <x-form.input id="lastname" type="text" name="lastname">Фамилия</x-form.input>
                <x-form.input id="fathername" type="text" name="fathername">Отчество</x-form.input>

                <label class="input-is-required" for="gender" required>Пол</label>
                <select name="gender" id="gender">
                    <option value="муж">муж</option>
                    <option value="жен">жен</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection
