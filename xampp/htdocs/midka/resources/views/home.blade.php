@extends('layouts.app')

@section('title', __('Главная'))

@section('content')

<section id="home" class="page active">
    <div class="hero">
        <div class="hero-content">
            <h1>{{ __('Твой гид в мире') }} <br>
                <span class="accent">{{ __('профессий') }}</span>
            </h1>
            <p>{{ __('Анализируй рынок труда через наши интерактивные отчеты в блоге.') }}</p>
            <div class="flex-btns">
                <button class="btn-gradient" onclick="window.location='/blog'">
                    {{ __('Смотреть аналитику') }}
                </button>
            </div>
        </div>

        <div class="ad-section">
            <div id="ad-banner" class="ad-card">
                <div id="ad-content">
                    <span class="label">{{ __('РЕКЛАМА') }}</span>
                    <h3>{{ __('Курс: Junior 2026') }}</h3>
                    <p>{{ __('Стань востребованным специалистом с нуля!') }}</p>
                    <button id="close-ad" class="btn-close">{{ __('Скрыть') }}</button>
                </div>
            </div>
            <div class="ad-controls">
                <button onclick="runFade()">Fade</button>
                <button onclick="runSlide()">Slide</button>
                <button onclick="runAnimate()">Animate</button>
                <button onclick="runToggle()">Show/Hide</button>
                <button onclick="stopAll()" class="stop-btn">STOP()</button>
            </div>
        </div>
    </div>
</section>

@endsection