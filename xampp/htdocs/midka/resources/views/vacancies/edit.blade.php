@extends('layouts.app')

@section('title', __('Редактировать вакансию'))

@section('content')
<div class="container" style="max-width:700px; margin:40px auto; padding:0 20px;">
    <div class="auth-card" style="background:white; padding:35px; border-radius:15px;">
        
        <h2 style="margin-bottom:25px; color:#1e1e2f;">{{ __('Редактировать вакансию') }}</h2>

        @if($errors->any())
            <div style="background:#fee2e2; color:#dc2626; padding:15px; border-radius:8px; margin-bottom:20px;">
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/vacancies/{{ $vacancy->id }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:18px;">
                <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Название вакансии') }}</label>
                <input type="text" name="title" value="{{ old('title', $vacancy->title) }}"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Компания') }}</label>
                <input type="text" name="company" value="{{ old('company', $vacancy->company) }}"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Описание') }}</label>
                <textarea name="description" rows="5"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; resize:vertical;">
                    {{ old('description', $vacancy->description) }}
                </textarea>
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Город') }}</label>
                <input type="text" name="location" value="{{ old('location', $vacancy->location) }}"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:18px;">
                <div>
                    <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Зарплата от') }}</label>
                    <input type="number" name="salary_from" value="{{ old('salary_from', $vacancy->salary_from) }}"
                        style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                </div>
                <div>
                    <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Зарплата до') }}</label>
                    <input type="number" name="salary_to" value="{{ old('salary_to', $vacancy->salary_to) }}"
                        style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                </div>
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Тип занятости') }}</label>
                <select name="type" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    @foreach(['full-time' => __('Полная занятость'),
                              'part-time' => __('Частичная занятость'),
                              'internship' => __('Стажировка'),
                              'remote' => __('Удалённо')] as $val => $label)
                        <option value="{{ $val }}" {{ old('type', $vacancy->type) == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Статус для админа/модератора --}}
            @if(auth()->user()->hasAnyRole(['admin', 'moderator']))
            <div style="margin-bottom:25px;">
                <label style="font-weight:bold; display:block; margin-bottom:6px;">{{ __('Статус') }}</label>
                <select name="status" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    <option value="pending"  {{ $vacancy->status == 'pending'  ? 'selected' : '' }}>⏳ {{ __('На модерации') }}</option>
                    <option value="approved" {{ $vacancy->status == 'approved' ? 'selected' : '' }}>✅ {{ __('Одобрено') }}</option>
                    <option value="rejected" {{ $vacancy->status == 'rejected' ? 'selected' : '' }}>❌ {{ __('Отклонено') }}</option>
                </select>
            </div>
            @endif

            <div style="display:flex; gap:12px;">
                <button type="submit"
                    style="flex:1; padding:13px; background:linear-gradient(135deg,#FF6B47,#F5A623); color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                    💾 {{ __('Сохранить') }}
                </button>
                <a href="/vacancies"
                    style="flex:1; padding:13px; background:#f1f5f9; color:#475569; border-radius:8px; text-align:center; text-decoration:none; font-weight:bold;">
                    {{ __('Отмена') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection