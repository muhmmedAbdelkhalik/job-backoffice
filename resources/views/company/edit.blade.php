@php
    $isAdmin = auth()->user()->role === 'admin';
    $isCompanyOwner = auth()->user()->role === 'company-owner';
    $formAction = $isAdmin ? route('company.update', $company->id) : route('my-company.update', $company->id);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- breadcrumb --}}
        @if ($isAdmin)
            <div class="flex items-center gap-2">
                <a href="{{ route('company.index') }}" class="text-blue-500">Companies</a>
                <span>/</span>
                <a href="{{ route('company.edit', $company->id) }}" class="text-blue-500">Edit Company</a>
            </div>

            <div class="h-4"></div>
        @endif
        @if ($isCompanyOwner)
            <div class="flex items-center gap-2">
                <a href="{{ route('my-company.show', $company->id) }}" class="text-blue-500">My Company</a>
                <span>/</span>
                <a href="{{ route('my-company.edit', $company->id) }}" class="text-blue-500">Edit Company</a>
            </div>
        @endif
        <div class="h-4"></div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    {{-- Company Details --}}
                    <h2 class="text-lg font-semibold mb-4">Company Details</h2>
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Company Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required
                            value="{{ $company->name }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" required
                            value="{{ $company->address }}" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="industry_id" :value="__('Industry')" />
                        <x-select-input id="industry_id" name="industry_id" class="mt-1 block w-full" :options="$industries->pluck('name', 'id')"
                            placeholder="Select an industry" selected="{{ $company->industry_id }}" required />
                        <x-input-error :messages="$errors->get('industry_id')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="website" :value="__('Website')" />
                        <x-text-input id="website" name="website" type="text" class="mt-1 block w-full" required
                            value="{{ $company->website }}" />
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>
                    {{-- Company Owner --}}
                    <h2 class="text-lg font-semibold mb-4">Company Owner</h2>
                    <div class="mb-4">
                        <x-input-label for="owner_id" :value="__('Owner')" />
                        <x-select-input id="owner_id" name="owner_id" class="mt-1 block w-full" :options="$users->pluck('name', 'id')"
                            placeholder="Select an owner" selected="{{ $company->owner_id }}" required />
                        <x-input-error :messages="$errors->get('owner_id')" class="mt-2" />
                    </div>


                    <div class="flex justify-end gap-2">
                        <a href="{{ $isAdmin ? route('company.index') : route('my-company.show', $company->id) }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
