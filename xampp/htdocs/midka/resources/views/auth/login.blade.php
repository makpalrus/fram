@extends('layouts.app')

@section('title', __('Войти в аккаунт'))

@section('content')
<div class="container">
    <div class="auth-card">
        <h2>{{ __('Войти в аккаунт') }}</h2>

        @if($errors->any())
            <div class="flash-error">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label>{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="example@mail.com" required>
            </div>

            <div class="form-group">
                <label>{{ __('Пароль') }}</label>
                <input type="password" name="password" placeholder="{{ __('Ваш пароль') }}" required>
            </div>

            <button type="submit" class="btn-gradient" style="width:100%">{{ __('Войти') }}</button>
        </form>

        <p style="text-align:center;margin-top:20px;font-size:14px">
            {{ __('Нет аккаунта?') }} 
            <a href="/register" style="color:#FF6B47;font-weight:700">{{ __('Зарегистрироваться') }}</a>
        </p>
    </div>
</div>
@endsection