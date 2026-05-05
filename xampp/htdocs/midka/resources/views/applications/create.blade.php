@extends('layouts.app')

@section('title', 'Откликнуться на вакансию')

@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding: 40px 20px;">
    <div class="auth-card" style="max-width:600px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
        
        <h2 style="color: #1e1e2f; margin-bottom: 10px; text-align: center;">Откликнуться</h2>
        <p style="text-align: center; color: #666; margin-bottom: 25px;">
            Вы откликаетесь на вакансию: <br>
            <strong style="color: #FF6B47; font-size: 1.2em;">{{ $vacancy->title }}</strong> <br>
            <span style="color: #888;">{{ $vacancy->company }}</span>
        </p>

        {{-- Вывод ошибок валидации --}}
        @if($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- ГЛАВНОЕ: enctype="multipart/form-data" обязательно для загрузки файлов --}}
        <form action="/vacancies/{{ $vacancy->id }}/apply" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Поле для сопроводительного письма --}}
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Сопроводительное письмо (необязательно)</label>
                <textarea name="cover_letter" rows="5" 
                    placeholder="Напишите, почему вы подходите на эту роль..."
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; resize: vertical;">{{ old('cover_letter') }}</textarea>
            </div>

            {{-- Поле для загрузки файла (как в лекции) --}}
            <div class="form-group" style="margin-bottom: 30px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Ваше резюме (PDF, DOC, DOCX)</label>
                <div style="position: relative; border: 2px dashed #FF6B47; padding: 20px; border-radius: 10px; text-align: center; background: #fff5f2;">
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                        style="cursor: pointer;">
                    <p style="font-size: 12px; color: #888; margin-top: 10px;">Максимальный размер файла: 2MB</p>
                </div>
            </div>

            {{-- Кнопка отправки --}}
            <button type="submit" class="btn-gradient" 
                style="width: 100%; border: none; padding: 15px; color: white; font-weight: bold; font-size: 16px; border-radius: 8px; cursor: pointer; background: linear-gradient(135deg, #FF6B47, #F5A623); box-shadow: 0 4px 15px rgba(255, 107, 71, 0.3);">
                Отправить отклик 🚀
            </button>

            <a href="/vacancies" style="display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 14px;">
                ← Вернуться к вакансиям
            </a>
        </form>
    </div>
</div>
@endsection