@extends('layouts.app')

@section('title', __('Регистрация'))

@section('content')
<div class="container">
    <div class="auth-card">
        <h2>{{ __('Создать аккаунт') }}</h2>

        @if($errors->any())
            <div class="flash-error">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="form-group">
                <label>{{ __('Имя') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('Ваше имя') }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com" required>
            </div>

            <div class="form-group">
                <label>{{ __('Пароль') }}</label>
                <input type="password" name="password" placeholder="{{ __('Минимум 6 символов') }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('Подтвердите пароль') }}</label>
                <input type="password" name="password_confirmation" placeholder="{{ __('Повторите пароль') }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('Я регистрируюсь как:') }}</label>
                <div class="radio-group">
                    <input type="radio" name="role" id="r_student" value="student"
                        {{ old('role','student') === 'student' ? 'checked' : '' }}>
                    <label for="r_student">{{ __('🎓 Студент (ищу работу)') }}</label>
                </div>
                <div class="radio-group">
                    <input type="radio" name="role" id="r_employer" value="employer"
                        {{ old('role') === 'employer' ? 'checked' : '' }}>
                    <label for="r_employer">{{ __('🏢 Работодатель (размещаю вакансии)') }}</label>
                </div>
            </div>

            <button type="submit" class="btn-gradient" style="width:100%">{{ __('Зарегистрироваться') }}</button>
        </form>

        <p style="text-align:center;margin-top:20px;font-size:14px">
            {{ __('Уже есть аккаунт?') }} 
            <a href="/login" style="color:#FF6B47;font-weight:700">{{ __('Войти') }}</a>
        </p>
    </div>
</div>
@endsection