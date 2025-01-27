<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Questionnaire - Events Five</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-gray-100 bg-pattern">
    <div class="progress-container">
        <div class="e5-progress-bar" id="progress-bar" style="width: 0%;"></div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
                 alt="Events Five Logo" 
                 class="e5-logo mx-auto mb-6">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-red-600">Questionnaire de Satisfaction</h1>
            <p class="text-gray-600 text-sm md:text-base">Bienvenue ! Nous avons 5 courtes questions suivies d'un espace pour vos commentaires.</p>
            <p class="text-gray-600 text-sm md:text-base mt-2">Votre avis est précieux pour améliorer nos services !</p>
        </div>

        <div id="quiz-container" class="max-w-2xl mx-auto">
            @foreach($questions as $index => $question)
                <div class="question-card mb-6 {{ $index === 0 ? '' : 'hidden' }}" id="question-{{ $index }}">
                    <div class="mb-4">
                        <h2 class="text-lg md:text-xl font-semibold mb-4 text-gray-800">{{ $question->question }}</h2>
                        <div class="space-y-3 md:space-y-4">
                            @foreach($question->options as $optionIndex => $option)
                                <label class="flex items-center cursor-pointer p-3 md:p-4 hover:bg-red-50 rounded-lg transition-all duration-200">
                                    <input type="radio" name="question_{{ $question->id }}" value="{{ $optionIndex }}" 
                                           class="radio-button" required>
                                    <span class="text-gray-700 text-sm md:text-base ml-3">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between mt-6 gap-4">
                        @if($index > 0)
                            <button onclick="showQuestion({{ $index - 1 }})" 
                                    class="e5-button py-2 px-4 md:px-6 rounded-md text-sm md:text-base">
                                Précédent
                            </button>
                        @else
                            <div></div>
                        @endif
                        <button onclick="nextQuestion({{ $index }})" 
                                class="e5-button py-2 px-4 md:px-6 rounded-md text-sm md:text-base">
                            Suivant
                        </button>
                    </div>
                </div>
            @endforeach

            <!-- Zone de commentaire libre -->
            <div class="question-card mb-6 hidden" id="question-feedback">
                <div class="mb-4">
                    <h2 class="text-lg md:text-xl font-semibold mb-4 text-gray-800">Pour finir, avez-vous des suggestions ou commentaires à nous faire ?</h2>
                    <p class="text-gray-600 text-sm md:text-base mb-4">Votre avis est important pour nous aider à nous améliorer.</p>
                    <textarea name="feedback" class="textarea-custom w-full" 
                              placeholder="Vos commentaires ici... (optionnel)"></textarea>
                </div>
                <div class="flex justify-between mt-6 gap-4">
                    <button onclick="showQuestion({{ count($questions) - 1 }})" 
                            class="e5-button py-2 px-4 md:px-6 rounded-md text-sm md:text-base">
                        Précédent
                    </button>
                    <button onclick="submitFeedback()" 
                            class="e5-button py-2 px-4 md:px-6 rounded-md text-sm md:text-base">
                        Terminer le questionnaire
                    </button>
                </div>
            </div>
        </div>

        <div id="results" class="hidden max-w-2xl mx-auto">
            <div class="question-card text-center">
                <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
                     alt="Events Five Logo" 
                     class="e5-logo mx-auto mb-6">
                <h2 class="text-xl md:text-2xl font-bold mb-4 text-red-600">Merci pour vos réponses !</h2>
                <div class="space-y-4">
                    <div class="check-animation mb-6">
                        <svg class="w-12 h-12 md:w-16 md:h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-base md:text-lg text-gray-700">Vos réponses ont été enregistrées avec succès.</p>
                    <p class="text-sm md:text-base text-gray-600">Nous apprécions le temps que vous avez pris pour répondre à notre questionnaire.</p>
                </div>
            </div>
        </div>

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
        </style>

        <script>
            let currentQuestion = 0;
            const totalQuestions = {{ count($questions) }} + 1;
            const questions = @json($questions);

            function updateProgressBar() {
                const progress = (currentQuestion / totalQuestions) * 100;
                document.getElementById('progress-bar').style.width = `${progress}%`;
            }

            function showQuestion(index) {
                document.querySelectorAll('.question-card').forEach(card => card.classList.add('hidden'));
                currentQuestion = index;
                if (index < {{ count($questions) }}) {
                    document.getElementById(`question-${index}`).classList.remove('hidden');
                } else {
                    document.getElementById('question-feedback').classList.remove('hidden');
                }
                updateProgressBar();
            }

            function nextQuestion(index) {
                const questionId = questions[index].id;
                const currentInputs = document.querySelectorAll(`input[name="question_${questionId}"]`);
                let isAnswered = false;
                currentInputs.forEach(input => {
                    if (input.checked) isAnswered = true;
                });

                if (!isAnswered && index < {{ count($questions) - 1 }}) {
                    alert('Veuillez sélectionner une réponse avant de continuer.');
                    return;
                }

                if (index < {{ count($questions) - 1 }}) {
                    showQuestion(index + 1);
                } else {
                    showQuestion({{ count($questions) }});
                }
            }

            async function submitFeedback() {
                try {
                    const feedback = document.querySelector('textarea[name="feedback"]').value || '';
                    const answers = {};
                    let hasAnswers = false;
                    
                    // Collecter toutes les réponses
                    questions.forEach((question, index) => {
                        const input = document.querySelector(`input[name="question_${question.id}"]:checked`);
                        if (input) {
                            answers[question.id] = parseInt(input.value);
                            hasAnswers = true;
                        }
                    });

                    if (!hasAnswers) {
                        alert('Veuillez répondre à au moins une question avant de terminer.');
                        return;
                    }

                    // Désactiver le bouton pendant la soumission
                    const submitButton = document.querySelector('button[onclick="submitFeedback()"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Envoi en cours...';

                    // Envoyer les réponses au serveur
                    const response = await fetch('{{ route("quiz.submit") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            answers: answers,
                            feedback: feedback
                        })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Erreur réseau');
                    }

                    const data = await response.json();
                    
                    if (data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = '{{ route("quiz.thank-you") }}';
                        }
                    } else {
                        throw new Error(data.message || 'Une erreur est survenue');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de l\'envoi de vos réponses: ' + error.message);
                    
                    // Réactiver le bouton
                    const submitButton = document.querySelector('button[onclick="submitFeedback()"]');
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Terminer le questionnaire';
                }
            }

            // Initialize progress bar
            updateProgressBar();
        </script>
    </div>
</body>
</html>
