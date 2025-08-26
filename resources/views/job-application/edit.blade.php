<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Application') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
            <form action="{{ route('job-application.update', $jobApplication->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    {{-- Job Application Details --}}
                    <h2 class="text-lg font-semibold mb-4">Job Application Details</h2>
                    <div class="mb-4">
                        <x-input-label for="job_vacancy_id" :value="__('Job Vacancy')" />
                        <span class="text-gray-500">{{ $jobApplication->jobVacancy->title }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="user_id" :value="__('Applicant')" />
                        <span class="text-gray-500">{{ $jobApplication->user->name }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="resume_id" :value="__('Resume')" />
                        <span class="text-gray-500">{{ $jobApplication->resume->file_name }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="ai_score" :value="__('AI Score')" />
                        <span class="text-gray-500">{{ $jobApplication->ai_score }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="ai_feedback" :value="__('AI Feedback')" />
                        <span class="text-gray-500">{{ $jobApplication->ai_feedback }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <x-select-input id="status" name="status" class="mt-1 block w-full" :options="[
                            'pending' => 'Pending',
                            'shortlisted' => 'Shortlisted',
                            'rejected' => 'Rejected',
                            'accepted' => 'Accepted',
                        ]"
                            placeholder="Select a status" selected="{{ $jobApplication->status }}" />
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('job-application.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Update Application Status
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
