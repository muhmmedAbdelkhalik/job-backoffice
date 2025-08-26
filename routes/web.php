<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacanyController;
use Illuminate\Support\Facades\Route;

// Shared routes for admin and company owner
Route::middleware('auth', 'role:admin,company-owner')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Job application routes
    Route::resource('/job-application', JobApplicationController::class);
    Route::put('/job-application/{jobApplication}/restore', [JobApplicationController::class, 'restore'])->name('job-application.restore');

    // Job vacancy routes
    Route::resource('/job-vacancy', JobVacanyController::class);
    Route::put('/job-vacancy/{jobVacancy}/restore', [JobVacanyController::class, 'restore'])->name('job-vacancy.restore');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Company owner routes
Route::middleware('auth', 'role:company-owner')->group(function () {
    // My company routes
    Route::get('/my-company', [CompanyController::class, 'showMyCompany'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
    Route::delete('/my-company', [CompanyController::class, 'destroy'])->name('my-company.destroy');
});

// Admin routes
Route::middleware('auth', 'role:admin')->group(function () {
    // User routes
    Route::resource('/user', UserController::class);
    Route::put('/user/{user}/restore', [UserController::class, 'restore'])->name('user.restore');

    // Company routes
    Route::resource('/company', CompanyController::class);
    Route::put('/company/{company}/restore', [CompanyController::class, 'restore'])->name('company.restore');

    // Job category routes
    Route::resource('/category', JobCategoryController::class);
    Route::put('/category/{category}/restore', [JobCategoryController::class, 'restore'])->name('category.restore');
});

require __DIR__ . '/auth.php';
