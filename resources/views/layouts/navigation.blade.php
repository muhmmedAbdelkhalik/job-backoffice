<nav x-data="{ open: false }" class="bg-white border-r border-gray-200 w-[250px] h-screen">
    <!-- Logo -->
    <div class="flex items-center px-6  border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            <span class="text-lg font-bold">
                {{ config('app.name') }}
            </span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col px-3 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
        @if (auth()->user()->role === 'admin')
            <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.index')">
                {{ __('Companies') }}
            </x-nav-link>
            <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')">
                {{ __('Job Categories') }}
            </x-nav-link>
            <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                {{ __('Users') }}
            </x-nav-link>
        @endif

        @if (auth()->user()->role === 'company-owner')
            <x-nav-link :href="route('my-company.show', ['tab' => 'vacancies'])" :active="request()->routeIs('my-company.show')">
                {{ __('My Company') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-application.index')" :active="request()->routeIs('job-application.index')">
            {{ __('Job Applications') }}
        </x-nav-link>


        <x-nav-link :href="route('job-vacancy.index')" :active="request()->routeIs('job-vacancy.index')">
            {{ __('Job Vacancies') }}
        </x-nav-link>


        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <x-nav-link :href="route('logout')" @click.prevent="$el.closest('form').submit()"
                class="text-red-500 hover:text-red-700">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </div>
</nav>
