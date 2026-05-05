@extends('layouts.app')

@section('title', __('Панель администратора'))

@section('content')
<div class="container" style="background:#1e1e2f;min-height:80vh">
    <h2 class="section-title">{{ __('Панель администратора') }}</h2>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:20px;margin:30px 0">
        @foreach([
            ['👥', __('Пользователей'), $stats['total_users']],
            ['📋', __('Вакансий'), $stats['total_vacancies']],
            ['⏳', __('На модерации'), $stats['pending']],
            ['✅', __('Одобрено'), $stats['approved']],
        ] as [$icon, $label, $val])
        <div style="background:white;border-radius:15px;padding:20px;text-align:center">
            <div style="font-size:28px">{{ $icon }}</div>
            <div style="font-size:28px;font-weight:700;color:#FF6B47">{{ $val }}</div>
            <div style="font-size:13px;color:#888">{{ $label }}</div>
        </div>
        @endforeach
    </div>
    <h3 style="color:white;margin-bottom:15px">Вакансии на модерации</h3>
    <div style="background:white;border-radius:15px;overflow:hidden;margin-bottom:30px">
        <table style="width:100%;border-collapse:collapse">
            <thead style="background:linear-gradient(135deg,#FF6B47,#F5A623)">
                <tr style="color:white;font-size:13px">
                    <th style="padding:12px 15px;text-align:left">Вакансия</th>
                    <th style="padding:12px 15px;text-align:left">Компания</th>
                    <th style="padding:12px 15px;text-align:left">Автор</th>
                    <th style="padding:12px 15px;text-align:left">Статус</th>
                    <th style="padding:12px 15px">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vacancies as $v)
                <tr style="border-bottom:1px solid #f0f0f0;font-size:13px">
                    <td style="padding:12px 15px">{{ $v->title }}</td>
                    <td style="padding:12px 15px">{{ $v->company }}</td>
                    <td style="padding:12px 15px">{{ $v->user->name ?? '—' }}</td>
                    <td style="padding:12px 15px">
                        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;
                            background:{{ $v->status==='approved'?'#d4edda':($v->status==='rejected'?'#f8d7da':'#fff3cd') }};
                            color:{{ $v->status==='approved'?'#155724':($v->status==='rejected'?'#721c24':'#856404') }}">
                            {{ $v->status }}
                        </span>
                    </td>
                    <td style="padding:12px 15px;text-align:center;display:flex;gap:8px;justify-content:center">
                        <a href="/vacancies/{{ $v->id }}/edit"
                            style="color:#FF6B47;font-size:12px;text-decoration:none;font-weight:700">Изменить</a>
                        <form method="POST" action="/vacancies/{{ $v->id }}"
                            onsubmit="return confirm('Удалить?')" style="display:inline">
                            @csrf @method('DELETE')
                            <button style="background:none;border:none;color:#999;cursor:pointer;font-size:12px">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
    <h3 style="color:white;margin-bottom:15px">Все пользователи</h3>
    <div style="background:white;border-radius:15px;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead style="background:#1e1e2f">
                <tr style="color:white;font-size:13px">
                    <th style="padding:12px 15px;text-align:left">ID</th>
                    <th style="padding:12px 15px;text-align:left">Имя</th>
                    <th style="padding:12px 15px;text-align:left">Email</th>
                    <th style="padding:12px 15px;text-align:left">Роль</th>
                    <th style="padding:12px 15px;text-align:left">Дата</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr style="border-bottom:1px solid #f0f0f0;font-size:13px">
                    <td style="padding:12px 15px;color:#888">{{ $u->id }}</td>
                    <td style="padding:12px 15px;font-weight:700">{{ $u->name }}</td>
                    <td style="padding:12px 15px;color:#555">{{ $u->email }}</td>
                    <td style="padding:12px 15px">
                        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;
                            background:{{ $u->role==='admin'?'#1e1e2f':($u->role==='moderator'?'#fff3cd':($u->role==='employer'?'#d4edda':'#e8f4ff')) }};
                            color:{{ $u->role==='admin'?'white':($u->role==='moderator'?'#856404':($u->role==='employer'?'#155724':'#004085')) }}">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td style="padding:12px 15px;color:#888;font-size:12px">{{ $u->created_at->format('d.m.Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection