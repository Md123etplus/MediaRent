<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: $persist(false) }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MediaRent - Location de matériel audiovisuel</title>
    <link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MediaRent" />

    <link rel="manifest" href="/images/favicon/site.webmanifest" />
    
    @livewireStyles
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @content('scripts') --}}
    @yield('styles')
   <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
</head>
<body class="min-h-screen flex flex-col bg-white dark:bg-gray-900">
    @include('components.navbar')
   
    <main class="flex-1">
        @yield('content')
        @yield('scripts')
    </main>
    
    @include('components.footer')
    
    @livewireScripts
    @stack('scripts')
</body>
</html>