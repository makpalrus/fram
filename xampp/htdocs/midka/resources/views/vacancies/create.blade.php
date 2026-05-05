@extends('layouts.app')

@section('title', __('Новая вакансия'))

@section('content')
<div class="container">
    <div class="auth-card" style="max-width:600px">
        <h2>{{ __('Разместить вакансию') }}</h2>

        @if($errors->any())
            <div class="flash-error">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="/vacancies">
            @csrf

            <div class="form-group">
                <label>{{ __('Название вакансии *') }}</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    placeholder="Frontend Developer, Стажёр..." required>
            </div>

            <div class="form-group">
                <label>{{ __('Компания *') }}</label>
                <input type="text" name="company" value="{{ old('company') }}"
                    placeholder="{{ __('Название компании') }}" required>
            </div>

            <div class="form-group">
                <label>{{ __('Описание *') }}</label>
                <textarea name="description" rows="5"
                    placeholder="{{ __('Опишите обязанности, требования...') }}" required
                    style="resize:vertical">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>{{ __('Город / Локация') }}</label>
                <input type="text" name="location" value="{{ old('location') }}"
                    placeholder="Алматы, Астана, Удалённо...">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
                <div class="form-group">
                    <label>{{ __('Зарплата от (₸)') }}</label>
                    <input type="number" name="salary_from" value="{{ old('salary_from') }}" min="0">
                </div>
                <div class="form-group">
                    <label>{{ __('Зарплата до (₸)') }}</label>
                    <input type="number" name="salary_to" value="{{ old('salary_to') }}" min="0">
                </div>
            </div>

            <div class="form-group">
                <label>{{ __('Тип занятости *') }}</label>
                <select name="type" required>
                    <option value="full-time"   {{ old('type')=='full-time'   ? 'selected':'' }}>{{ __('Полная занятость') }}</option>
                    <option value="part-time"   {{ old('type')=='part-time'   ? 'selected':'' }}>{{ __('Частичная занятость') }}</option>
                    <option value="internship"  {{ old('type')=='internship'  ? 'selected':'' }}>{{ __('Стажировка') }}</option>
                    <option value="remote"      {{ old('type')=='remote'      ? 'selected':'' }}>{{ __('Удалённо') }}</option>
                </select>
            </div>

            <button type="submit" class="btn-gradient" style="width:100%">
                {{ __('Опубликовать вакансию') }}
            </button>
        </form>
    </div>
</div>
@endsection