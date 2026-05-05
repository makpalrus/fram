<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Montserrat, sans-serif; color: #333; }
        .header { background: linear-gradient(135deg, #FF6B47, #F5A623); padding: 20px; color: white; }
        .content { padding: 20px; }
        .label { color: #888; font-size: 13px; }
        .value { font-weight: 700; font-size: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>StepUp — Новый отклик</h2>
    </div>
    <div class="content">
        <p class="label">Вакансия:</p>
        <p class="value">{{ $application->vacancy->title }} — {{ $application->vacancy->company }}</p>

        <p class="label">Студент:</p>
        <p class="value">{{ $application->user->name }} ({{ $application->user->email }})</p>

        @if($application->cover_letter)
        <p class="label">Сопроводительное письмо:</p>
        <p>{{ $application->cover_letter }}</p>
        @endif

        @if($application->resume_path)
        <p class="label">Резюме:</p>
        <p>Файл прикреплён к заявке</p>
        @endif

        <hr>
        <p style="color:#888;font-size:12px">StepUp 2026 — Гид для студентов</p>
    </div>
</body>
</html>