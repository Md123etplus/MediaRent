<!DOCTYPE html>
<html lang="fr" class="{{ $darkMode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediaRent - Location de matériel audiovisuel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-white dark:bg-gray-900">
    @include('components.navbar')
    
    <main class="flex-1">
        {{ $slot }}
    </main>

    @include('components.footer')
</body>
</html>