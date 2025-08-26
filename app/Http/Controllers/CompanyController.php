<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::with(['industry', 'owner'])->latest()->paginate(10)->onEachSide(1);
        $archive = false;

        if ($request->input('archive')) {
            $companies = Company::with(['industry', 'owner'])->onlyTrashed()->paginate(10)->onEachSide(1);
            $archive = true;
        }

        return view('company.index', compact('companies', 'archive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = Industry::all();
        $users = User::where('role', 'company-owner')->get();
        return view('company.create', compact('industries', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();
        Company::create($validated);
        return redirect()->route('company.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $company = Company::with(['industry', 'owner'])->findOrFail($id);
        return $this->showCompanyData($company, $request);
    }

    /**
     * Display the authenticated user's company.
     */
    public function showMyCompany(Request $request)
    {
        $company = Auth::user()->company;
        if (!$company) {
            abort(404, 'Company not found');
        }
        return $this->showCompanyData($company, $request);
    }

    /**
     * Helper method to show company data with tabs.
     */
    private function showCompanyData(Company $company, Request $request)
    {
        $activeTab = $request->get('tab', 'vacancies');

        $data = [
            'company' => $company,
            'activeTab' => $activeTab
        ];

        if ($activeTab === 'vacancies') {
            $data['vacancies'] = $company->jobVacancies()->latest()->get();
        } elseif ($activeTab === 'applications') {
            $data['applications'] = $company->jobApplications()->latest()->get();
        }

        return view('company.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?string $id = null)
    {
        if (Auth::user()->role === 'company-owner' && $id === null) {
            // Company owner editing their own company
            $company = Auth::user()->company;
            if (!$company) {
                abort(404, 'Company not found');
            }
        } else {
            // Admin editing a specific company
            $company = Company::with(['industry', 'owner'])->findOrFail($id);
        }

        $industries = Industry::all();
        $users = User::where('role', 'company-owner')->get();
        return view('company.edit', [
            'company' => $company,
            'industries' => $industries,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, ?string $id = null)
    {
        if (Auth::user()->role === 'company-owner' && $id === null) {
            $company = Auth::user()->company;
            if (!$company) {
                abort(404, 'Company not found');
            }
        } else {
            $company = Company::with(['industry', 'owner'])->findOrFail($id);
        }
        $validated = $request->validated();
        $company->update($validated);
        if (Auth::user()->role === 'company-owner') {
            return redirect()->route('my-company.show', $company->id)->with('success', 'Company updated successfully');
        } else {
            return redirect()->route('company.index')->with('success', 'Company updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company deleted successfully');
    }

    public function restore(string $id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index', ['archive' => true])->with('success', 'Company restored successfully');
    }
}
