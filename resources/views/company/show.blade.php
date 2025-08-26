<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company Details') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- breadcrumb --}}
        @if (auth()->user()->role === 'admin')
            <div class="flex items-center gap-2">
                <a href="{{ route('company.index') }}" class="text-blue-500">Companies</a>
                <span>/</span>
                <a href="{{ route('company.show', $company->id) }}" class="text-blue-500">{{ $company->name }}</a>
            </div>
            <div class="h-4"></div>
        @endif


        {{-- company details --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
            <div class="p-6">
                <h2 class="text-xl font-semibold">{{ $company->name }}</h2>
                <p class="text-gray-500">Industry: {{ $company->industry->name ?? 'Not specified' }}</p>
                <p class="text-gray-500">Address: {{ $company->address }}</p>
                <p class="text-gray-500">Website: <a href="{{ $company->website }}" target="_blank"
                        class="text-blue-500">{{ $company->website }}</a></p>
                <p class="text-gray-500">Owner: <a href="{{ route('user.show', $company->owner->id) }}"
                        class="text-blue-500">{{ $company->owner->name }}</a></p>
            </div>
            <div class="flex justify-end gap-2 p-6">
                @if (auth()->user()->role === 'company-owner')
                    <a href="{{ route('my-company.edit', $company->id) }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit Company</a>
                @endif
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('company.edit', $company->id) }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                    <form action="{{ route('company.destroy', $company->id) }}" method="POST">
                        @csrf 
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                    </form>
                @endif
            </div>
        </div>
        @if (auth()->user()->role === 'admin')
            {{-- job vacancies and applications --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
                <div class="border-b">
                    <nav class="flex">
                        <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'vacancies']) }}"
                            class="px-4 py-2 font-medium hover:text-blue-500 {{ $activeTab === 'vacancies' ? 'border-b-2 border-blue-500' : '' }}">
                            Job Vacancies
                        </a>
                        <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 font-medium hover:text-blue-500 {{ $activeTab === 'applications' ? 'border-b-2 border-blue-500' : '' }}">
                            Job Applications
                        </a>
                    </nav>
                </div>

                <div class="p-6">
                    @if ($activeTab === 'vacancies')
                        <div>
                            @if (isset($vacancies) && $vacancies->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($vacancies as $vacancy)
                                        <div class="border rounded-lg p-4">
                                            <h3 class="font-semibold text-lg">{{ $vacancy->title }}</h3>
                                            <p class="text-gray-600">{{ $vacancy->description }}</p>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <span class="mr-4">Type: {{ $vacancy->type }}</span>
                                                <span>Salary: ${{ number_format($vacancy->salary) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No job vacancies found for this company.</p>
                            @endif
                        </div>
                    @elseif($activeTab === 'applications')
                        <div>
                            @if (isset($applications) && $applications->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($applications as $application)
                                        <div class="border rounded-lg p-4">
                                            <h3 class="font-semibold text-lg">
                                                {{ $application->applicant->name ?? 'Unknown Applicant' }}</h3>
                                            <p class="text-gray-600">Applied for:
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
                    @endif
                </div>
            </div>
        @endif
    </div>



</x-app-layout>
