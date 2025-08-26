<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        {{-- breadcrumb --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('user.index') }}" class="text-blue-500">Users</a>
            <span>/</span>
            <a href="{{ route('user.show', $user->id) }}" class="text-blue-500">{{ $user->name }}</a>
        </div>

        <div class="h-4"></div>

        {{-- user details --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
            <div class="p-6">
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-500">Email: {{ $user->email }}</p>
                <p class="text-gray-500">Role: {{ $user->role }}</p>
                <p class="text-gray-500">Created At: {{ $user->created_at->format('M d, Y') }}</p>
                <p class="text-gray-500">Updated At: {{ $user->updated_at->format('M d, Y') }}</p>
                <p class="text-gray-500">Resumes:
                    @if ($resumes->count() > 0)
                        @foreach ($resumes as $resume)
                            <a class="text-blue-500" href="{{ $resume->file_url }}"
                                target="_blank">{{ $resume->file_name }}</a>
                        @endforeach
                    @else
                        <span class="text-gray-500">No resumes found</span>
                    @endif
                </p>
            </div>
            <div class="flex justify-end gap-2 p-6">
                <a href="{{ route('user.edit', $user->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
    </div>



</x-app-layout>
