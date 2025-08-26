<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $data = $this->getAdminDashboardData();
        } else {
            $data = $this->getCompanyOwnerDashboardData();
        }

        return view('dashboard.index', $data);
    }

    public function getAdminDashboardData()
    {
        // last 30 days users (job seekers)
        $last30DaysUsers = User::where('last_login_at', '>=', now()->subDays(30))->where('role', 'job-seeker')->count();

        // Total jobs (not deleted)
        $totalJobs = JobVacany::whereNull('deleted_at')->count();

        // Total applications
        $totalApplications = JobApplication::count();

        $analytics = [
            'last30DaysUsers' => $last30DaysUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
        ];

        // most applied jobs
        $mostAppliedJobs = JobVacany::withCount('applications')->orderBy('applications_count', 'desc')->take(5)->get();

        // conversion rate  
        $conversionRate = JobVacany::withCount('applications')->orderBy('applications_count', 'desc')
            ->having('applications_count', '>', 0)
            ->limit(5)
            ->get()->map(function ($item) {
                if ($item->view_count > 0) {
                    $item->rate = ($item->applications_count / $item->view_count) * 100;
                } else {
                    $item->rate = 0;
                }
                return $item;
            });

        return [
            'analytics' => $analytics,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRate' => $conversionRate,
        ];
    }

    public function getCompanyOwnerDashboardData()
    {
        // filter active users by applying to jobs of the company
        $last30DaysUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('applications', function ($query) {
                $query->whereHas('jobVacancy', function ($query) {
                    $query->where('company_id', Auth::user()->company->id);
                });
            })
            ->count();

        // total jobs of the company
        $totalJobs = JobVacany::where('company_id', Auth::user()->company->id)->count();

        // total applications of the company
        $totalApplications = JobApplication::whereHas('jobVacancy', function ($query) {
            $query->where('company_id', Auth::user()->company->id);
        })->count();

        $analytics = [
            'last30DaysUsers' => $last30DaysUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
        ];

        // most applied jobs
        $mostAppliedJobs = JobVacany::withCount('applications')->where('company_id', Auth::user()->company->id)->orderBy('applications_count', 'desc')->take(5)->get();

        // conversion rate  
        $conversionRate = JobVacany::withCount('applications')->where('company_id', Auth::user()->company->id)->orderBy('applications_count', 'desc')
            ->having('applications_count', '>', 0)
            ->limit(5)
            ->get()->map(function ($item) {
                if ($item->view_count > 0) {
                    $item->rate = ($item->applications_count / $item->view_count) * 100;
                } else {
                    $item->rate = 0;
                }
                return $item;
            });

        return [
            'analytics' => $analytics,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRate' => $conversionRate,
        ];
    }
}
