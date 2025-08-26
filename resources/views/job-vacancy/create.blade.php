<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
            <form action="{{ route('job-vacancy.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    {{-- Company Details --}}
                    <h2 class="text-lg font-semibold mb-4">Job Vacancy Details</h2>
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Job Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"  />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-area-input id="description" name="description" class="mt-1 block w-full"
                             />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                             />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="salary" :value="__('Salary')" />
                        <x-text-input id="salary" name="salary" type="number" class="mt-1 block w-full"  />
                        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="type" :value="__('Type')" />
                        <x-select-input id="type" name="type" class="mt-1 block w-full" :options="[
                            'full-time' => 'Full-time',
                            'part-time' => 'Part-time',
                            'hybrid' => 'Hybrid',
                            'remote' => 'Remote',
                        ]"
                            placeholder="Select a type"  />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="company_id" :value="__('Company')" />
                        <x-select-input id="company_id" name="company_id" class="mt-1 block w-full" :options="$companies->pluck('name', 'id')"
                            placeholder="Select a company"  />
                        <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <x-select-input id="category_id" name="category_id" class="mt-1 block w-full" :options="$categories->pluck('name', 'id')"
                            placeholder="Select a category"  />
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('job-vacancy.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Add Job Vacancy
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
