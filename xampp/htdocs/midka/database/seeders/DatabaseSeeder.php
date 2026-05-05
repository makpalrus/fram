<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создать тестовых пользователей
        $admin = User::create([
            'name' => 'Admin', 'email' => 'admin@stepup.com',
            'password' => Hash::make('password'), 'role' => 'admin'
        ]);
        User::create([
            'name' => 'Moderator', 'email' => 'mod@stepup.com',
            'password' => Hash::make('password'), 'role' => 'moderator'
        ]);
        $employer = User::create([
            'name' => 'Employer', 'email' => 'emp@stepup.com',
            'password' => Hash::make('password'), 'role' => 'employer'
        ]);
        User::create([
            'name' => 'Student', 'email' => 'student@stepup.com',
            'password' => Hash::make('password'), 'role' => 'student'
        ]);

        // Тестовые вакансии
        $vacancies = [
            ['title'=>'Frontend Developer (React)', 'company'=>'Kaspi Bank',
             'description'=>'Ищем студента для работы над веб-интерфейсами на React.js',
             'location'=>'Алматы', 'salary_from'=>150000, 'salary_to'=>250000,
             'type'=>'internship', 'status'=>'approved'],
            ['title'=>'Data Analyst Intern', 'company'=>'Freedom Finance',
             'description'=>'Анализ данных, работа с SQL и Python',
             'location'=>'Астана', 'salary_from'=>120000, 'salary_to'=>200000,
             'type'=>'part-time', 'status'=>'approved'],
            ['title'=>'Backend PHP Developer', 'company'=>'Digital Hub KZ',
             'description'=>'Laravel, MySQL, REST API разработка',
             'location'=>'Удалённо', 'salary_from'=>200000, 'salary_to'=>350000,
             'type'=>'remote', 'status'=>'approved'],
        ];

        foreach ($vacancies as $v) {
            Vacancy::create(array_merge($v, ['user_id' => $employer->id]));
        }
    }
}