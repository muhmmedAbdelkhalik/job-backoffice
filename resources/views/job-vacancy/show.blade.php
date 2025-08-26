<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancy Details') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- breadcrumb --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('job-vacancy.index') }}" class="text-blue-500">Job Vacancies</a>
            <span>/</span>
            <a href="{{ route('job-vacancy.show', $jobVacancy->id) }}" class="text-blue-500">{{ $jobVacancy->title }}</a>
        </div>

        <div class="h-4"></div>

        {{-- company details --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
            <div class="p-6">
                <h2 class="text-xl font-semibold">{{ $jobVacancy->title }}</h2>
                <p class="text-gray-500">Company: {{ $jobVacancy->company->name ?? 'Not specified' }}</p>
                <p class="text-gray-500">Location: {{ $jobVacancy->location }}</p>
                <p class="text-gray-500">Type: {{ $jobVacancy->type }}</p>
                <p class="text-gray-500">Salary: {{ $jobVacancy->salary }}</p>
            </div>
            <div class="flex justify-end gap-2 p-6">
                <a href="{{ route('job-vacancy.edit', $jobVacancy->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
        {{-- applications --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
            <div class="border-b">
                <nav class="flex">
                    <a class="px-4 py-2 font-medium hover:text-blue-500 {{ 'border-b-2 border-blue-500' }}">
                        Applications
                    </a>
                </nav>
            </div>

            <div class="p-6">
                <div>
                    @if ($applications->count() > 0)
                        <div class="space-y-4">
                            @foreach ($applications as $application)
                                <div class="border rounded-lg p-4">
                                    <h3 class="font-semibold text-lg">
                                        {{ $application->applicant->name ?? 'Unknown Applicant' }}</h3>
                                    <p class="text-gray-600">
                                        {{ $application->jobVacancy->title ?? 'Unknown Position' }}</p>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <span class="mr-4">Status: {{ $application->status }}</span>
                                        <span>Applied: {{ $application->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No job applications found for this company.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>



</x-app-layout>
