<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacany::latest();

        if (Auth::user()->role === 'company-owner') {
            $query->where('company_id', Auth::user()->company->id);
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1);
        $archive = false;

        if ($request->input('archive')) {
            $jobVacancies = JobVacany::latest()->onlyTrashed()->paginate(10)->onEachSide(1);
            $archive = true;
        }

        return view('job-vacancy.index', compact('jobVacancies', 'archive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $categories = JobCategory::all();
        return view('job-vacancy.create', compact('companies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacany::create($validated);
        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobVacany $jobVacancy)
    {
        $jobVacancy = $jobVacancy->load(['company', 'category', 'applications']);
        $applications = $jobVacancy->applications()->latest()->get();

        return view('job-vacancy.show', [
            'jobVacancy' => $jobVacancy,
            'applications' => $applications
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacany $jobVacancy)
    {
        $companies = Company::all();
        $categories = JobCategory::all();
        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacany::findOrFail($id);
        $jobVacancy->update($validated);
        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacany::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy deleted successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobVacancy = JobVacany::withTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy restored successfully');
    }
}
