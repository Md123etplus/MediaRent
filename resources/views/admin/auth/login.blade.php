<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - MediaRent</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .bg-auth {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- En-tête -->
                <div class="bg-auth py-6 px-8 text-white">
                    <h1 class="text-2xl font-bold text-center">
                        <i class="fas fa-lock mr-2"></i>Espace Admin
                    </h1>
                    <p class="text-center text-blue-100 mt-1">MediaRent - Panel de gestion</p>
                </div>

                <!-- Formulaire -->
                <form class="p-8" action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <!-- Champ Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>Email admin
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                            placeholder="admin@exemple.com"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-key mr-2 text-blue-500"></i>Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="mot_pass" 
                            required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                    </button>
                </form>

                <!-- Pied de page -->
                <div class="bg-gray-50 px-8 py-4 text-center border-t">
                    <p class="text-sm text-gray-600">
                        &copy; {{ date('Y') }} MediaRent. Tous droits réservés.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Animation simple au chargement
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            form.classList.add('animate__animated', 'animate__fadeInUp');
        });
    </script>
</body>
</html>