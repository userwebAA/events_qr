<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donnez-nous votre avis - Events Five</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @yield('content')
</body>
</html>
