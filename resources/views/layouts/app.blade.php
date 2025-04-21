<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: $persist(false) }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediaRent - Location de matériel audiovisuel</title>
    <link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MediaRent" />
    <link rel="manifest" href="/images/favicon/site.webmanifest" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-white dark:bg-gray-900">
    @include('components.navbar')
    {{-- <div class="p-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Test Dark Mode</h1>
        <p class="text-gray-700 dark:text-gray-300">Ce texte devrait changer de couleur</p>
        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
          <p class="text-gray-800 dark:text-gray-200">Ce conteneur devrait aussi changer</p>
        </div>MAH  JMZH
      </div> --}}
    <main class="flex-1">
        @yield('content')
    </main>
    @include('components.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>