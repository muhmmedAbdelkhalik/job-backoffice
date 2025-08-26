<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\User;
use App\Models\JobVacany;
use App\Models\Resume;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $this->call([
            IndustrySeeder::class,
        ]);
        // Create Admin User
        User::firstOrCreate([
            'name' => 'Admin',
        ], [
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
        // Seed data from json file
        $jobData = file_get_contents(database_path('data/job_data.json'));
        $jobData = json_decode($jobData, true);
        foreach ($jobData['jobCategories'] as $jobCategory) {
            JobCategory::firstOrCreate([
                'name' => $jobCategory,
            ]);
        }

        // Create Company
        foreach ($jobData['companies'] as $company) {
            // Create fake user as company owner
            $companyOwner = User::firstOrCreate([
                'email' => $faker->unique()->safeEmail(),
            ], [
                'name' => $faker->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);
            
            // Find the industry by name and get its ID
            $industry = \App\Models\Industry::where('name', $company['industry'])->first();
            
            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry_id' => $industry ? $industry->id : null,
                'website' => $company['website'],
                'owner_id' => $companyOwner->id,
            ]);
        }

        // Create Job Vacancies
        foreach ($jobData['jobVacancies'] as $jobVacancy) {

            $company = Company::where('name', $jobVacancy['company'])->first();

            $category = JobCategory::where('name', $jobVacancy['category'])->first();

            JobVacany::firstOrCreate([
                'title' => $jobVacancy['title'],
                'company_id' => $company->id,
            ], [
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'type' => $jobVacancy['type'],
                'salary' => $jobVacancy['salary'],
                'company_id' => $company->id,
                'category_id' => $category->id,
            ]);
        }

        // Seed job applications
        $jobApplications = file_get_contents(database_path('data/job_applications.json'));
        $jobApplications = json_decode($jobApplications, true);

        // Create Job Applications
        foreach ($jobApplications['jobApplications'] as $jobApplication) {
            // Get random job vacancy
            $jobVacancy = JobVacany::inRandomOrder()->first();
            // Create applicant user
            $applicant = User::firstOrCreate([
                'email' => $faker->unique()->safeEmail(),
            ], [
                'name' => $faker->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);
            // Create resume
            $resume = Resume::create([
                'file_name' => $jobApplication['resume']['filename'],
                'file_url' => $jobApplication['resume']['fileUri'],
                'contact_details' => $jobApplication['resume']['contactDetails'],
                'education' => $jobApplication['resume']['education'],
                'summary' => $jobApplication['resume']['summary'],
                'skills' => $jobApplication['resume']['skills'],
                'experience' => $jobApplication['resume']['experience'],
                'user_id' => $applicant->id,
            ]);

            // Create job application
            JobApplication::create([
                'status' => $jobApplication['status'],
                'ai_score' => $jobApplication['aiGeneratedScore'],
                'ai_feedback' => $jobApplication['aiGeneratedFeedback'],
                'user_id' => $applicant->id,
                'resume_id' => $resume->id,
                'job_vacancy_id' => $jobVacancy->id,
            ]);
        }
    }
}
