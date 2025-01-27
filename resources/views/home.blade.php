<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Five - Questionnaire</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 border-t-4 border-red-600">
            <div class="text-center">
                <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" alt="Events Five Logo" class="e5-logo mx-auto">
                <h1 class="text-2xl font-bold mb-6 text-red-600">Votre Avis Compte</h1>
            </div>

            <div class="flex justify-center mb-6">
                <div class="p-4 bg-white rounded-lg shadow-sm">
                    {!! $qrcode !!}
                </div>
            </div>

            <div class="text-center">
                <p class="mb-4 text-gray-600">Scannez ce QR code pour nous donner votre avis sur votre expérience !</p>
                <p class="mb-6 text-sm text-gray-500">Votre retour nous aide à nous améliorer</p>
                <a href="{{ route('quiz.show') }}"
                   class="e5-button py-2 px-4 rounded-md inline-block">
                    Donner mon avis
                </a>
            </div>
        </div>
    </div>
</body>
</html>
