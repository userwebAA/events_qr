<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci - Events Five</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .check-animation {
            animation: scale-up 0.5s ease-in-out;
        }
        
        @keyframes scale-up {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .material-icons {
            font-size: 48px;
            color: #22c55e;
        }
    </style>
</head>
<body class="bg-gray-100 bg-pattern">
    <div class="container mx-auto px-4 py-8">
        <div class="question-card text-center max-w-md mx-auto">
            <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
                 alt="Events Five Logo" 
                 class="e5-logo mx-auto mb-6">
            
            <div class="check-animation mb-6">
                <span class="material-icons">check</span>
            </div>

            <h1 class="text-2xl font-bold mb-4 text-red-600">Merci pour vos réponses !</h1>
            
            <div class="space-y-4 mb-8">
                <p class="text-lg text-gray-700">Vos réponses ont été enregistrées avec succès.</p>
                <p class="text-gray-600">Nous apprécions le temps que vous avez pris pour partager votre expérience.</p>
                <p class="text-gray-600">Votre avis nous aide à améliorer continuellement nos services.</p>
            </div>

            <a href="{{ route('home') }}" 
               class="e5-button py-3 px-6 rounded-md inline-block">
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
