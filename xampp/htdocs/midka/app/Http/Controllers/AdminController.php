<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacancy;

class AdminController extends Controller
{
    public function index()
    {
        $users      = User::latest()->get();
        $vacancies  = Vacancy::with('user')->latest()->get();
        $stats = [
            'total_users'     => User::count(),
            'total_vacancies' => Vacancy::count(),
            'pending'         => Vacancy::where('status', 'pending')->count(),
            'approved'        => Vacancy::where('status', 'approved')->count(),
        ];
        return view('admin.dashboard', compact('users', 'vacancies', 'stats'));
    }
}