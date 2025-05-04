<!DOCTYPE html>
<html lang="fr" x-data="header">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediaRent - Location de matériel audiovisuel</title>
    <!-- Favicons (keep all existing) -->
    <link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MediaRent" />
    <link rel="manifest" href="/images/favicon/site.webmanifest" />
    
    @vite(['resources/css/app.css'])
    @yield('styles')
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    @livewireStyles
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000">

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</head>
<body class="min-h-screen flex flex-col bg-white dark:bg-gray-900">
    @include('components.navbar')
   
    <main class="flex-1">
        @yield('content')
        @yield('scripts')
    </main>
    @include('components.footer')
    
    @livewireScripts <!-- Changed from ScriptConfig to Scripts -->
    @vite(['resources/js/app.js']) <!-- Load after Livewire -->
</body>
</html>