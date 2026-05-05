@extends('layouts.app')

@section('title', __('Вакансии'))

@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding: 20px; border-radius: 15px;">
    
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px">
        <h2 class="section-title" style="color: white;">{{ __('Вакансии для студентов') }}</h2>
        
        @auth
            @if(in_array(auth()->user()->role, ['employer', 'admin']))
                <a href="/vacancies/create" class="btn-gradient" style="text-decoration: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; color: white; background: linear-gradient(135deg, #FF6B47, #F5A623);">
                    + {{ __('Добавить вакансию') }}
                </a>
            @endif
        @endauth
    </div>

    <div class="blog-grid" style="margin-top:30px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($vacancies as $v)
            <div class="blog-card" style="background: white; padding: 20px; border-radius: 12px; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                
                <div style="display:flex; justify-content:space-between; align-items:start">
                    <div>
                        <h3 style="margin:0 0 5px; color:#1e1e2f">{{ $v->title }}</h3>
                        <p style="color:#FF6B47; font-weight:700; margin:0">{{ $v->company }}</p>
                    </div>
                    <span style="background:linear-gradient(135deg,#FF6B47,#F5A623); color:white; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700">
                        {{ $v->type }}
                    </span>
                </div>

                <p style="color:#555; margin:12px 0; font-size:14px; line-height: 1.5;">
                    {{ Str::limit($v->description, 120) }}
                </p>

                <div style="display:flex; gap:15px; font-size:13px; color:#888; flex-wrap:wrap">
                    @if($v->location) <span>📍 {{ $v->location }}</span> @endif
                    @if($v->salary_from)
                        <span>💰 {{ number_format($v->salary_from, 0, '.', ' ') }} 
                        @if($v->salary_to) – {{ number_format($v->salary_to, 0, '.', ' ') }} @endif ₸</span>
                    @endif
                </div>

                @auth
                    @if(in_array(auth()->user()->role, ['employer', 'moderator', 'admin']))
                        <div style="display:flex; gap:10px; margin-top:15px; border-top: 1px solid #eee; pt: 10px;">
                            <a href="/vacancies/{{ $v->id }}/edit" style="font-size:13px; color:#FF6B47; text-decoration:none; font-weight:700">
                                ✏️ {{ __('Изменить') }}
                            </a>
                            <form method="POST" action="/vacancies/{{ $v->id }}" onsubmit="return confirm('{{ __('Удалить вакансию?') }}')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:#999; cursor:pointer; font-size:13px">
                                    🗑 {{ __('Удалить') }}
                                </button>
                            </form>
                        </div>
                    @endif

                    @if(auth()->user()->role === 'student')
                        <div style="margin-top:15px">
                            <a href="/vacancies/{{ $v->id }}/apply" 
                               style="background: #FF6B47; color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px; display: inline-block; width: 100%; text-align: center; font-weight: bold;">
                                {{ __('Откликнуться (Загрузить резюме) →') }}
                            </a>
                        </div>
                    @endif

                @else
                    <div style="margin-top:15px">
                        <a href="/login" style="font-size:13px; color:#F5A623; text-decoration:none; font-weight:700">
                            🔐 {{ __('Войдите, чтобы откликнуться') }}
                        </a>
                    </div>
                @endauth
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                <p style="color:rgba(255,255,255,.5); font-size: 18px;">{{ __('Пока нет доступных вакансий') }}</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top:30px">
        {{ $vacancies->links() }}
    </div>
</div>
@endsection