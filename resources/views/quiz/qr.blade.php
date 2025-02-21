<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - Events Five</title>
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

        .qr-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 500px;
            margin: 1rem;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        .qr-card {
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
        }

        .qr-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .qr-text {
            font-size: 1.1rem;
            color: #4b5563;
            margin-bottom: 2rem;
            line-height: 1.6;
            padding: 0 1rem;
        }

        .qr-code {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .qr-code svg {
            width: 100%;
            max-width: 250px;
            height: auto;
        }

        .e5-button {
            display: inline-block;
            padding: 1rem 2rem;
            background-color: #dc2626;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .e5-button:hover {
            background-color: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3);
        }

        .button-container {
            margin-top: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .qr-container {
                padding: 1rem;
                margin: 0.5rem;
            }

            .qr-card {
                padding: 1.5rem;
            }

            .e5-logo {
                width: 140px;
                margin-bottom: 1.5rem;
            }

            .qr-title {
                font-size: 1.75rem;
                padding: 0 0.5rem;
            }

            .qr-text {
                font-size: 1rem;
                padding: 0 0.5rem;
                margin-bottom: 1.5rem;
            }

            .qr-code {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .qr-code svg {
                max-width: 200px;
            }

            .e5-button {
                padding: 0.875rem 1.75rem;
                font-size: 1rem;
                width: 100%;
                box-sizing: border-box;
            }
        }

        /* Pour les très petits écrans */
        @media (max-width: 360px) {
            .qr-card {
                padding: 1.25rem;
            }

            .e5-logo {
                width: 120px;
            }

            .qr-title {
                font-size: 1.5rem;
            }

            .qr-code {
                padding: 0.75rem;
            }

            .qr-code svg {
                max-width: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <div class="qr-card">
            <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
                 alt="Events Five Logo" 
                 class="e5-logo">
            
            <h1 class="qr-title">Scannez le QR Code</h1>
            
            <p class="qr-text">
                Pour accéder au questionnaire, vous pouvez scanner le QR code ci-dessous avec votre smartphone ou cliquer sur le bouton en bas.
            </p>

            <div class="qr-code">
                {!! $qrCode !!}
            </div>

            <div class="button-container">
                <a href="{{ route('quiz.show') }}" class="e5-button">
                    Accéder au quiz
                </a>
            </div>
        </div>
    </div>
</body>
</html>
