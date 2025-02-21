<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci - Events Five</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .thank-you-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 650px;
            margin: 1rem;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .thank-you-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .e5-logo {
            width: 180px;
            height: auto;
            margin-bottom: 2rem;
            animation: fadeIn 0.6s ease-out;
        }

        .check-circle {
            width: 90px;
            height: 90px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            background-color: #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
            box-shadow: 0 6px 16px rgba(34, 197, 94, 0.25);
        }

        .check-circle svg {
            width: 45px;
            height: 45px;
            color: white;
            animation: checkmark 0.5s ease-out 0.2s both;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes checkmark {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .thank-you-title {
            font-size: 2.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.25rem;
            line-height: 1.2;
            animation: slideUp 0.5s ease-out 0.3s both;
            padding: 0 1rem;
        }

        .thank-you-text {
            font-size: 1.15rem;
            color: #4b5563;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            animation: slideUp 0.5s ease-out 0.4s both;
            padding: 0 1rem;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .e5-button {
            display: inline-block;
            padding: 1rem 2.5rem;
            background-color: #dc2626;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            animation: slideUp 0.5s ease-out 0.5s both;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .e5-button:hover {
            background-color: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .thank-you-container {
                padding: 1rem;
                margin: 0.5rem;
            }

            .thank-you-card {
                padding: 2rem 1.5rem;
            }

            .e5-logo {
                width: 140px;
                margin-bottom: 1.5rem;
            }

            .check-circle {
                width: 80px;
                height: 80px;
                margin-bottom: 1.75rem;
            }

            .check-circle svg {
                width: 40px;
                height: 40px;
            }

            .thank-you-title {
                font-size: 1.75rem;
                margin-bottom: 1rem;
                padding: 0 0.5rem;
            }

            .thank-you-text {
                font-size: 1.05rem;
                margin-bottom: 2rem;
                padding: 0 0.5rem;
            }

            .e5-button {
                padding: 0.875rem 2rem;
                font-size: 1rem;
                width: 100%;
                box-sizing: border-box;
            }
        }

        /* Pour les très petits écrans */
        @media (max-width: 360px) {
            .thank-you-card {
                padding: 1.5rem 1rem;
            }

            .e5-logo {
                width: 120px;
                margin-bottom: 1.25rem;
            }

            .check-circle {
                width: 70px;
                height: 70px;
                margin-bottom: 1.5rem;
            }

            .check-circle svg {
                width: 35px;
                height: 35px;
            }

            .thank-you-title {
                font-size: 1.5rem;
            }

            .thank-you-text {
                font-size: 1rem;
                margin-bottom: 1.75rem;
            }

            .e5-button {
                padding: 0.75rem 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <div class="thank-you-card">
            <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
                 alt="Events Five Logo" 
                 class="e5-logo">
            
            <div class="check-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="thank-you-title">Merci pour votre retour !</h1>
            
            <p class="thank-you-text">
                Nous apprécions grandement votre participation. Vos réponses nous aideront à améliorer nos services et à vous offrir une expérience encore meilleure.
            </p>

            <a href="{{ route('home') }}" class="e5-button">
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
