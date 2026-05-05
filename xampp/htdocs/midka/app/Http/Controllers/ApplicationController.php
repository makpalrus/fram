<?php
namespace App\Http\Controllers;

use App\Mail\ApplicationMail;
use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function create(Vacancy $vacancy)
    {
        return view('applications.create', compact('vacancy'));
    }

    public function store(Request $request, Vacancy $vacancy)
{
    if ($request->hasFile('resume')) {
        $file = $request->file('resume');
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        $file->move(public_path('uploads/resumes'), $fileName);
        
        $path = 'uploads/resumes/' . $fileName;
    }

    \App\Models\Application::create([
        'vacancy_id' => $vacancy->id,
        'user_id' => auth()->id(),
        'resume_path' => $path,
        'cover_letter' => $request->cover_letter
    ]);

    return redirect('/vacancies')->with('success', 'Отклик отправлен!');
}
}