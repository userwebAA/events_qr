<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - Table {{ $tableId }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" alt="Events Five Logo" class="e5-logo mx-auto">
            </div>
            <h1 class="text-2xl font-bold text-center mb-6">QR Code pour la Table {{ $tableId }}</h1>
            
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-white rounded-lg shadow-sm">
                    {!! $qrCode !!}
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('quiz.show', $tableId) }}" target="_blank" 
                   class="inline-block bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    Voir le Quiz
                </a>
                
                <a href="{{ route('admin.index') }}" 
                   class="inline-block mt-4 text-indigo-600 hover:text-indigo-800">
                    ← Retour
                </a>
            </div>
        </div>
    </div>
</body>
</html>
