<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'MediaRent' }}</title>
    @vite('resources/css/app.css') <!-- Assurez-vous que votre CSS est correctement lié -->
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        {{ $slot }}
    </div>
</body>
</html>