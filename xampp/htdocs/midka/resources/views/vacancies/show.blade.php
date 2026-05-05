@extends('layouts.app')

@section('title', $vacancy->title)

@section('content')
<div class="container" style="background:#1e1e2f;min-height:80vh">

    {{-- Кнопка назад --}}
    <a href="/vacancies"
        style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);
        text-decoration:none;font-size:14px;margin-bottom:25px">
        ← {{ __('Назад к вакансиям') }}
    </a>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:30px;align-items:start"
         class="vacancy-show-grid">

        {{-- ЛЕВАЯ КОЛОНКА — основная информация --}}
        <div>
            {{-- Заголовок --}}
            <div style="background:white;border-radius:20px;padding:30px;margin-bottom:20px">
                <div style="display:flex;justify-content:space-between;align-items:start;flex-wrap:wrap;gap:15px">
                    <div>
                        <h1 style="margin:0 0 8px;color:#1e1e2f;font-size:1.8rem">
                            {{ $vacancy->title }}
                        </h1>
                        <p style="color:#FF6B47;font-weight:700;font-size:1.1rem;margin:0">
                            {{ $vacancy->company }}
                        </p>
                    </div>
                    <span style="background:linear-gradient(135deg,#FF6B47,#F5A623);
                        color:white;padding:6px 18px;border-radius:20px;
                        font-size:13px;font-weight:700;white-space:nowrap">
                        {{ match($vacancy->type) {
                            'full-time'  => __('💼 Полная занятость'),
                            'part-time'  => __('⏰ Частичная'),
                            'internship' => __('🎓 Стажировка'),
                            'remote'     => __('🌐 Удалённо'),
                            default      => $vacancy->type
                        } }}
                    </span>
                </div>

                {{-- Метаданные --}}
                <div style="display:flex;flex-wrap:wrap;gap:20px;margin-top:20px;
                    padding-top:20px;border-top:1px solid #f0f0f0">
                    @if($vacancy->location)
                    <div style="display:flex;align-items:center;gap:8px;color:#555;font-size:14px">
                        <span style="font-size:18px">📍</span>
                        <span>{{ $vacancy->location }}</span>
                    </div>
                    @endif

                    @if($vacancy->salary_from)
                    <div style="display:flex;align-items:center;gap:8px;color:#555;font-size:14px">
                        <span style="font-size:18px">💰</span>
                        <span>
                            {{ number_format($vacancy->salary_from) }}
                            @if($vacancy->salary_to)
                                – {{ number_format($vacancy->salary_to) }}
                            @endif
                            ₸
                        </span>
                    </div>
                    @endif

                    <div style="display:flex;align-items:center;gap:8px;color:#555;font-size:14px">
                        <span style="font-size:18px">📅</span>
                        <span>{{ $vacancy->created_at->format('d.m.Y') }}</span>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;font-size:14px">
                        <span style="font-size:18px">🔖</span>
                        <span style="padding:3px 12px;border-radius:20px;font-size:12px;font-weight:700;
                            background:{{ $vacancy->status==='approved'?'#d4edda':($vacancy->status==='rejected'?'#f8d7da':'#fff3cd') }};
                            color:{{ $vacancy->status==='approved'?'#155724':($vacancy->status==='rejected'?'#721c24':'#856404') }}">
                            {{ match($vacancy->status) {
                                'approved' => '✅ ' . __('Одобрено'),
                                'rejected' => '❌ ' . __('Отклонено'),
                                default    => '⏳ ' . __('На модерации')
                            } }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Описание --}}
            <div style="background:white;border-radius:20px;padding:30px">
                <h2 style="color:#1e1e2f;font-size:1.1rem;margin:0 0 15px;
                    padding-bottom:12px;border-bottom:2px solid #f0f0f0">
                    📄 {{ __('Описание вакансии') }}
                </h2>
                <div style="color:#444;font-size:15px;line-height:1.8;white-space:pre-line">
                    {{ $vacancy->description }}
                </div>
            </div>
        </div>

        {{-- ПРАВАЯ КОЛОНКА — действия --}}
        <div style="position:sticky;top:90px">

            {{-- Кнопка отклика для студента --}}
            @auth
                @if(auth()->user()->hasRole('student'))
                <div style="background:white;border-radius:20px;padding:25px;margin-bottom:20px;text-align:center">
                    <p style="color:#555;font-size:14px;margin:0 0 15px">
                        {{ __('Заинтересовала вакансия?') }}
                    </p>
                    <a href="/vacancies/{{ $vacancy->id }}/apply"
                        class="btn-gradient"
                        style="display:block;text-align:center;padding:14px">
                        {{ __('Откликнуться →') }}
                    </a>
                </div>
                @endif

                {{-- Кнопки управления для employer/moderator/admin --}}
                @if(auth()->user()->hasAnyRole(['employer','moderator','admin']))
                <div style="background:white;border-radius:20px;padding:25px;margin-bottom:20px">
                    <p style="color:#888;font-size:12px;font-weight:700;
                        text-transform:uppercase;letter-spacing:1px;margin:0 0 15px">
                        {{ __('Управление') }}
                    </p>
                    <a href="/vacancies/{{ $vacancy->id }}/edit"
                        style="display:block;text-align:center;padding:12px;
                        background:linear-gradient(135deg,#FF6B47,#F5A623);
                        color:white;border-radius:10px;text-decoration:none;
                        font-weight:700;font-size:14px;margin-bottom:10px">
                        ✏️ {{ __('Редактировать') }}
                    </a>
                    <form method="POST" action="/vacancies/{{ $vacancy->id }}"
                        onsubmit="return confirm('{{ __('Удалить вакансию?') }}')">
                        @csrf @method('DELETE')
                        <button style="width:100%;padding:12px;background:#f8f9fc;
                            border:1px solid #eee;border-radius:10px;color:#999;
                            cursor:pointer;font-size:14px;font-family:inherit">
                            🗑 {{ __('Удалить') }}
                        </button>
                    </form>
                </div>
                @endif

            @else
                {{-- Гость --}}
                <div style="background:white;border-radius:20px;padding:25px;text-align:center">
                    <p style="color:#555;font-size:14px;margin:0 0 15px">
                        {{ __('Войдите чтобы откликнуться') }}
                    </p>
                    <a href="/login" class="btn-gradient"
                        style="display:block;text-align:center;padding:14px">
                        {{ __('Войти') }}
                    </a>
                    <a href="/register"
                        style="display:block;margin-top:10px;color:#FF6B47;
                        font-size:13px;font-weight:700;text-decoration:none">
                        {{ __('Нет аккаунта? Зарегистрироваться') }}
                    </a>
                </div>
            @endauth

            {{-- Информация о работодателе --}}
            <div style="background:white;border-radius:20px;padding:25px">
                <p style="color:#888;font-size:12px;font-weight:700;
                    text-transform:uppercase;letter-spacing:1px;margin:0 0 15px">
                    {{ __('Работодатель') }}
                </p>
                <div style="display:flex;align-items:center;gap:12px">
                    <div style="width:45px;height:45px;border-radius:50%;
                        background:linear-gradient(135deg,#FF6B47,#F5A623);
                        display:flex;align-items:center;justify-content:center;
                        color:white;font-weight:700;font-size:18px;flex-shrink:0">
                        {{ mb_substr($vacancy->company, 0, 1) }}
                    </div>
                    <div>
                        <p style="margin:0;font-weight:700;color:#1e1e2f;font-size:15px">
                            {{ $vacancy->company }}
                        </p>
                        <p style="margin:3px 0 0;color:#888;font-size:13px">
                            {{ $vacancy->user->name ?? __('Работодатель') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Адаптив для мобильных --}}
<style>
@media (max-width: 768px) {
    .vacancy-show-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

@endsection