<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Application Details') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- breadcrumb --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('job-application.index') }}" class="text-blue-500">Job Applications</a>
            <span>/</span>
            <a href="{{ route('job-application.show', $jobApplication->id) }}"
                class="text-blue-500">{{ $jobApplication->jobVacancy->title }}</a>
        </div>

        <div class="h-4"></div>

        {{-- Application details --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
            <div class="p-6">
                <h2 class="text-xl font-semibold">{{ $jobApplication->jobVacancy->title }}</h2>
                <p class="text-gray-500">Company: {{ $jobApplication->jobVacancy->company->name ?? 'Not specified' }}
                </p>
                <p class="text-gray-5 00">Location: {{ $jobApplication->jobVacancy->location }}</p>
                <p class="text-gray-500">Type: {{ $jobApplication->jobVacancy->type }}</p>
                <p class="text-gray-500">Salary: {{ $jobApplication->jobVacancy->salary }}</p>
                <p class="text-gray-500">Status: <x-status :status="$jobApplication->status" />
                </p>
                <p class="text-gray-500">Applied: {{ $jobApplication->created_at->format('M d, Y') }}</p>
                <p class="text-gray-500">Resume: <a href="{{ $jobApplication->resume->file_url }}" target="_blank">View
                        Resume</a></p>
            </div>
            <div class="flex justify-end gap-2 p-6">
                <a href="{{ route('job-application.edit', $jobApplication->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
        {{-- Resume tab and AI Feedback tab --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
            <div class="border-b">
                <nav class="flex">
                    <a href="{{ route('job-application.show', ['job_application' => $jobApplication, 'tab' => 'resume']) }}"
                        class="px-4 py-2 font-medium hover:text-blue-500 {{ $activeTab === 'resume' ? 'border-b-2 border-blue-500' : '' }}">
                        Resume
                    </a>
                    <a href="{{ route('job-application.show', ['job_application' => $jobApplication, 'tab' => 'feedback']) }}"
                        class="px-4 py-2 font-medium hover:text-blue-500 {{ $activeTab === 'feedback' ? 'border-b-2 border-blue-500' : '' }}">
                        Feedback
                    </a>
                </nav>
            </div>
            <div class="p-6">
                @if ($activeTab === 'resume')
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 px-4 font-medium bg-gray-50">Education</td>
                                    <td class="py-2 px-4">{{ $jobApplication->resume->education ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 font-medium bg-gray-50">Summary</td>
                                    <td class="py-2 px-4">{{ $jobApplication->resume->summary ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 font-medium bg-gray-50">Skills</td>
                                    <td class="py-2 px-4">{{ $jobApplication->resume->skills ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 font-medium bg-gray-50">Experience</td>
                                    <td class="py-2 px-4">{{ $jobApplication->resume->experience ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif($activeTab === 'feedback')
                    <div>
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg">AI Feedback</h3>
                            <p class="text-gray-600">{{ $jobApplication->ai_feedback }}</p>
                        </div>
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-lg">AI Score</h3>
                            <p class="text-gray-600">{{ $jobApplication->ai_score }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>



</x-app-layout>
