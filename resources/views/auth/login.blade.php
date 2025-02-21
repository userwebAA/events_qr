<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Events Five Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('{{ asset('images/WhatsApp Image 2025-02-12 at 4.46.52 PM.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .e5-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 2rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #dc2626;
            ring-color: #dc2626;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .e5-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #dc2626;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .e5-button:hover {
            background-color: #b91c1c;
        }

        @media (max-width: 640px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="text-center">
                <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
                     alt="Events Five Logo" 
                     class="e5-logo mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Administration</h2>
            </div>

            @if ($errors->any())
                <div class="error-message mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           class="form-input">
                </div>

                <div>
                    <label for="password" class="block text-gray-700">Mot de passe</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="form-input">
                </div>

                <div>
                    <button type="submit" class="e5-button">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
