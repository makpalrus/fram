<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StepUp | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Step<span style="color:#FF6B47">Up</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">{{ __('Главная') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/blog">{{ __('Новости') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/vacancies">{{ __('Вакансии') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('О нас') }}</a>
                </li>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">{{ __('Админ') }}</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item">
                        <span class="nav-link" style="color: rgba(255,255,255,.7)">
                            {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="/logout" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link"
                                style="color:rgba(255,255,255,.7); cursor:pointer">
                                {{ __('Выход') }}
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/register">{{ __('Регистрация') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">{{ __('Войти') }}</a>
                    </li>
                @endauth

                {{-- Переключатель языка --}}
                @include('partials.lang-switcher')
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    </div>
@endif

<main class="py-4">
    @yield('content')
</main>

<footer class="main-footer" style="background:#1e1e2f; color:rgba(255,255,255,.5); text-align:center; padding:20px;">
    <p>{{ __('© StepUp 2026 — Гид для студентов по поиску работы') }}</p>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>