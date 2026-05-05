<?php
namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{

    public function index()
    {
        $vacancies = Vacancy::with('user')
            ->where('status', 'approved')
            ->latest()
            ->paginate(9);
        return view('vacancies.index', compact('vacancies'));
    }

public function show(Vacancy $vacancy)
{
    $vacancy->load('user');
    return view('vacancies.show', compact('vacancy'));
}

    public function create()
    {
        return view('vacancies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'company'     => 'required|string|max:200',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:200',
            'salary_from' => 'nullable|numeric|min:0',
            'salary_to'   => 'nullable|numeric|min:0',
            'type'        => 'required|in:full-time,part-time,internship,remote',
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = auth()->user()->hasAnyRole(['admin', 'moderator']) ? 'approved' : 'pending';

        Vacancy::create($data);

        return redirect('/vacancies')->with('success', 'Вакансия отправлена на модерацию!');
    }

    public function edit(Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);
        return view('vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);

        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'company'     => 'required|string|max:200',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:200',
            'salary_from' => 'nullable|numeric|min:0',
            'salary_to'   => 'nullable|numeric|min:0',
            'type'        => 'required|in:full-time,part-time,internship,remote',
            'status'      => 'sometimes|in:pending,approved,rejected',
        ]);

        $vacancy->update($data);
        return redirect('/vacancies')->with('success', 'Вакансия обновлена');
    }

    public function destroy(Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);
        $vacancy->delete();
        return redirect('/vacancies')->with('success', 'Вакансия удалена');
    }


    public function apiIndex()
    {
        return response()->json(
            Vacancy::with('user:id,name')->where('status', 'approved')->latest()->get()
        );
    }

    public function apiShow(Vacancy $vacancy)
    {
        return response()->json($vacancy->load('user:id,name'));
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'company'     => 'required|string|max:200',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:200',
            'salary_from' => 'nullable|numeric',
            'salary_to'   => 'nullable|numeric',
            'type'        => 'required|in:full-time,part-time,internship,remote',
        ]);
        $data['user_id'] = auth()->id();
        $data['status']  = 'pending';

        $vacancy = Vacancy::create($data);
        return response()->json($vacancy, 201);
    }

    public function apiUpdate(Request $request, Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);
        $vacancy->update($request->validate([
            'title'       => 'sometimes|string|max:200',
            'company'     => 'sometimes|string|max:200',
            'description' => 'sometimes|string',
            'location'    => 'nullable|string|max:200',
            'salary_from' => 'nullable|numeric',
            'salary_to'   => 'nullable|numeric',
            'type'        => 'sometimes|in:full-time,part-time,internship,remote',
            'status'      => 'sometimes|in:pending,approved,rejected',
        ]));
        return response()->json($vacancy);
    }

    public function apiDestroy(Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);
        $vacancy->delete();
        return response()->json(['message' => 'Вакансия удалена']);
    }


    private function authorizeVacancy(Vacancy $vacancy): void
{
    $user = auth()->user();
    
    if ($user->hasAnyRole(['admin', 'moderator'])) {
        return;
    }
    
    if ($vacancy->user_id !== $user->id) {
        abort(403, 'Нет доступа к этой вакансии');
    }
}
}