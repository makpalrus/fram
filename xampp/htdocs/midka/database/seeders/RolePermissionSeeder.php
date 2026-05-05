<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Сброс кеша ролей и прав
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // СОЗДАНИЕ ПРАВ (PERMISSIONS)
        // ============================================
        
        // Права для вакансий
        Permission::create(['name' => 'view jobs']);
        Permission::create(['name' => 'create jobs']);
        Permission::create(['name' => 'edit own jobs']);
        Permission::create(['name' => 'delete own jobs']);
        Permission::create(['name' => 'edit any job']);
        Permission::create(['name' => 'delete any job']);
        
        // Права для пользователей
        Permission::create(['name' => 'manage users']);
        
        // Права для админ-панели
        Permission::create(['name' => 'view admin panel']);

        // ============================================
        // СОЗДАНИЕ РОЛЕЙ
        // ============================================
        
        // 1. ADMIN (полный доступ)
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // 2. MODERATOR (модератор)
        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo([
            'view jobs',
            'edit any job',
            'delete any job',
            'manage users',
            'view admin panel',
        ]);

        // 3. EMPLOYER (работодатель)
        $employer = Role::create(['name' => 'employer']);
        $employer->givePermissionTo([
            'view jobs',
            'create jobs',
            'edit own jobs',
            'delete own jobs',
        ]);

        // 4. STUDENT (студент)
        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo([
            'view jobs',
        ]);

        // ============================================
        // СОЗДАНИЕ ТЕСТОВЫХ ПОЛЬЗОВАТЕЛЕЙ
        // ============================================
        
        // Admin
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@stepup.kz',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('admin');

        // Moderator
        $moderatorUser = User::create([
            'name' => 'Moderator',
            'email' => 'mod@stepup.kz',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $moderatorUser->assignRole('moderator');

        // Employer
        $employerUser = User::create([
            'name' => 'Google HR',
            'email' => 'hr@google.kz',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $employerUser->assignRole('employer');

        // Student
        $studentUser = User::create([
            'name' => 'Aruzhan',
            'email' => 'aruzhan@student.kz',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $studentUser->assignRole('student');
    }
}