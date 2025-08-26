<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-2xl mx-auto">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    {{-- User Details --}}
                    <h2 class="text-lg font-semibold mb-4">User Details</h2>
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <span class="text-gray-500">{{ $user->name }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <span class="text-gray-500">{{ $user->email }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Role')" />
                        <span class="text-gray-500">{{ $user->role }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="created_at" :value="__('Created At')" />
                        <span class="text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="updated_at" :value="__('Updated At')" />
                        <span class="text-gray-500">{{ $user->updated_at->format('d M Y') }}</span>
                    </div>
                    <!-- Change Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Change Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>



                    <div class="flex justify-end gap-2">
                        <a href="{{ route('user.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
