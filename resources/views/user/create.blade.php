<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    {{-- Company Details --}}
                    <h2 class="text-lg font-semibold mb-4">User Details</h2>
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Role')" />
                        <x-select-input id="role" name="role" class="mt-1 block w-full" :options="[
                            'admin' => 'Admin',
                            'company-owner' => 'Company Owner',
                            'job-seeker' => 'Job Seeker',
                        ]"
                            placeholder="Select a role" />
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>


                    <div class="flex justify-end gap-2">
                        <a href="{{ route('user.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Add User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
