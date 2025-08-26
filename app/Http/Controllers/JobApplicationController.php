<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::latest();

        if (Auth::user()->role === 'company-owner') {
            $query->whereHas('jobVacancy', function ($query) {
                $query->where('company_id', Auth::user()->company->id);
            });
        }

        $archive = false;

        if ($request->input('archive')) {
            $query->onlyTrashed();
            $archive = true;
        }

        $jobApplications = $query->paginate(10)->onEachSide(1);

        return view('job-application.index', compact('jobApplications', 'archive'));
    }


    /**
     * Display the specified resource.
     */
    public function show(String $id, Request $request)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $activeTab = $request->get('tab', 'resume');
        return view('job-application.show', compact('jobApplication', 'activeTab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(String $id, JobApplicationUpdateRequest $request)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update($request->validated());
        return redirect()->route('job-application.index')->with('success', 'Job application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-application.index')->with('success', 'Job application deleted successfully');
    }

    public function restore(String $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-application.index')->with('success', 'Job application restored successfully');
    }
}
