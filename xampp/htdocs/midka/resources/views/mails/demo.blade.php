<!DOCTYPE html>
<html>
<body>
    <h2>
        Новый отклик на вакансию:
        {{ $application->vacancy->title }}
    </h2>

    <p>
        <strong>Отправитель:</strong>
        {{ auth()->user()->name }}
    </p>

    <p>
        <strong>Письмо:</strong>
        {{ $application->cover_letter }}
    </p>

    <p>Резюме во вложении или в папке uploads.</p>
</body>
</html>
