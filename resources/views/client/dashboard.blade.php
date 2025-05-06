@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Modern Blue Sidebar (fixed) -->
    <div class="hidden md:flex md:w-64 flex-col fixed h-full">
        <div class="flex flex-col flex-grow bg-blue-600 pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4 mb-8">
                <h2 class="text-2xl font-bold text-white">MediaRent</h2>
            </div>
            <div class="flex-grow flex flex-col">
                <nav class="flex-1 space-y-2 px-4">
                    <a href="{{ route('client.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('client.dashboard') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-500 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Tableau de bord
                    </a>
                    <a href="{{ route('client.reservations.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('client.reservations*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-500 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Mes réservations
                    </a>
                    <a href="{{ route('client.evaluations.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('client.evaluations*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-500 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Mes évaluations
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content (with padding for sidebar) -->
    <div class="flex-1 flex flex-col overflow-hidden md:ml-64">
        <main class="flex-1 overflow-y-auto p-6">
            @yield('client-content')
        </main>
    </div>
</div>
@endsection