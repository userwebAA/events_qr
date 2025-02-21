@extends('layouts.app')

@section('content')
<div class="quiz-container">
    <div class="quiz-card">
        <img src="{{ asset('images/Black and Red Bold Prime Rib Steak Product Features Instagram Post.svg') }}" 
             alt="Events Five Logo" 
             class="e5-logo">

        <form id="quizForm" class="space-y-8" method="POST">
            @csrf
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                <div class="question {{ $index === 0 ? 'active' : '' }}" data-question-id="{{ $question->id }}" style="{{ $index === 0 ? '' : 'display: none;' }}">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">{{ $question->content }}</h3>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($question->options as $optionIndex => $option)
                            <button type="button"
                                    class="option-button text-left px-6 py-4 border-2 border-gray-200 rounded-lg hover:border-red-500 hover:bg-red-50 transition-colors"
                                    data-question-id="{{ $question->id }}"
                                    data-value="{{ $option }}">
                                {{ $option }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="feedback-container bg-gray-50 rounded-lg p-6 mt-8 shadow-sm transition-all duration-300 transform hover:shadow-md" style="display: none;">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-comment-alt text-red-500 mr-3 text-xl"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Votre avis nous intéresse !</h3>
                    </div>
                    <p class="text-gray-600 mb-4">N'hésitez pas à nous faire part de vos suggestions ou commentaires pour améliorer notre service.</p>
                    <textarea name="feedback" rows="4" 
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors duration-200"
                              placeholder="Partagez votre expérience avec nous..."
                              style="resize: vertical; min-height: 120px;"></textarea>
                </div>
            </div>

            <div class="progress-container">
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 0%"></div>
                </div>
                <div class="progress-text">Question <span id="currentQuestionNumber">1</span> sur 6</div>
            </div>

            <div class="flex justify-between mt-8">
                <button type="button" 
                        class="e5-button prev" 
                        id="prevButton"
                        style="display: none;">
                    Précédent
                </button>
                <button type="button" 
                        class="e5-button next" 
                        id="nextButton">
                    Suivant
                </button>
                <button type="submit" 
                        class="e5-button submit" 
                        id="submitButton"
                        style="display: none;">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Styles existants... */
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

    .quiz-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 650px;
        margin: 2rem;
    }

    .quiz-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .e5-logo {
        width: 180px;
        height: auto;
        margin: 0 auto 2.5rem;
        display: block;
    }

    .progress-container {
        width: 100%;
        height: 8px;
        background-color: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
        margin: 2rem 0;
        position: relative;
    }

    .progress-bar {
        height: 100%;
        background-color: #ef4444;
        transition: width 0.3s ease-in-out;
        border-radius: 9999px;
    }

    .progress-text {
        position: absolute;
        top: -1.5rem;
        right: 0;
        font-size: 0.875rem;
        color: #4b5563;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: absolute;
        width: 100%;
        top: -0.75rem;
    }

    .progress-step {
        width: 16px;
        height: 16px;
        background-color: #f3f4f6;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        transition: all 0.3s ease-in-out;
    }

    .progress-step.active {
        background-color: #ef4444;
        border-color: #ef4444;
    }

    .progress-step.completed {
        background-color: #ef4444;
        border-color: #ef4444;
    }

    .question {
        display: none;
    }

    .question.active {
        display: block;
    }

    .feedback-container {
        display: none;
    }

    .feedback-container.active {
        display: block;
    }

    .options-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .option-button {
        display: flex;
        align-items: center;
        gap: 1rem;
        width: 100%;
        padding: 1rem 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        background-color: white;
        color: #374151;
        font-size: 1rem;
        font-weight: 500;
        text-align: left;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .option-button {
        background-color: white;
        transition: all 0.3s ease;
    }
    
    .option-button:hover {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    
    /* Style pour l'option sélectionnée */
    .option-button.selected {
        background-color: #fef2f2;
        border-color: #ef4444;
    }

    .option-button {
        position: relative;
    }
    
    .option-button {
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .option-button:hover {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    
    .option-button.selected {
        background-color: #fef2f2;
        border-color: #ef4444;
    }

    .navigation-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .e5-button {
        padding: 0.875rem 1.75rem;
        font-size: 1rem;
        font-weight: 500;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
    }

    .e5-button.prev {
        background-color: #f3f4f6;
        color: #4b5563;
    }

    .e5-button.prev:hover {
        background-color: #e5e7eb;
    }

    .e5-button.next {
        background-color: #dc2626;
        color: white;
    }

    .e5-button.next:hover {
        background-color: #b91c1c;
    }

    .e5-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    textarea {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        margin: 1rem 0;
        resize: vertical;
        min-height: 120px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    textarea:focus {
        outline: none;
        border-color: #dc2626;
    }

    @media (max-width: 640px) {
        .quiz-container {
            margin: 1rem;
        }

        .quiz-card {
            padding: 1.5rem;
            border-radius: 15px;
        }

        .e5-logo {
            width: 140px;
            margin-bottom: 2rem;
        }

        .question h2 {
            font-size: 1.25rem;
        }

        .option-button {
            padding: 0.875rem 1rem;
        }

        .e5-button {
            padding: 0.75rem 1.25rem;
            min-width: 100px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quizForm');
    const questions = document.querySelectorAll('.question');
    const progressBar = document.querySelector('.progress-bar');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');
    const feedbackContainer = document.querySelector('.feedback-container');
    const currentQuestionSpan = document.getElementById('currentQuestionNumber');
    const totalSteps = questions.length + 1;
    
    let currentStep = 0;
    
    // Gestionnaire pour les options
    document.querySelectorAll('.option-button').forEach(button => {
        button.addEventListener('click', function() {
            // Désélectionner toutes les options de la question courante
            const question = this.closest('.question');
            question.querySelectorAll('.option-button').forEach(opt => {
                opt.classList.remove('selected');
            });
            // Sélectionner l'option cliquée
            this.classList.add('selected');
        });
    });
    
    function updateProgress() {
        const progress = ((currentStep + 1) / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
        currentQuestionSpan.textContent = currentStep + 1;
    }
    
    function showStep(index) {
        questions.forEach(q => q.style.display = 'none');
        feedbackContainer.style.display = 'none';
        
        if (index < questions.length) {
            questions[index].style.display = 'block';
            currentQuestionSpan.textContent = index + 1;
            document.querySelector('.progress-text').textContent = `Question ${index + 1} sur 6`;
        } else {
            feedbackContainer.style.display = 'block';
            currentQuestionSpan.textContent = '6';
            document.querySelector('.progress-text').textContent = 'Dernière étape';
        }
        
        prevButton.style.display = index > 0 ? 'block' : 'none';
        
        if (index === questions.length) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }
        
        updateProgress();
    }
    
    prevButton.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });
    
    nextButton.addEventListener('click', () => {
        if (currentStep < questions.length) {
            const currentQuestionElement = questions[currentStep];
            const selectedOption = currentQuestionElement.querySelector('.option-button.selected');
            
            if (!selectedOption) {
                alert('Veuillez sélectionner une réponse avant de continuer.');
                return;
            }
            
            currentStep++;
            showStep(currentStep);
        }
    });
    
    submitButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        let hasAllAnswers = true;
        const responses = [];
        
        questions.forEach((question) => {
            const questionId = question.getAttribute('data-question-id');
            const selectedOption = question.querySelector('.option-button.selected');
            
            if (selectedOption) {
                responses.push({
                    question_id: parseInt(questionId),
                    selected_option: selectedOption.getAttribute('data-value')
                });
            } else {
                hasAllAnswers = false;
            }
        });
        
        if (!hasAllAnswers) {
            alert('Veuillez répondre à toutes les questions avant d\'envoyer.');
            return;
        }
        
        const feedback = document.querySelector('textarea[name="feedback"]').value;
        
        fetch('{{ route("responses.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                table_id: '{{ $tableId }}' || 'default',
                responses: responses,
                feedback: feedback
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Erreur lors de l\'envoi des réponses');
                });
            }
            return response.json();
        })
        .then(data => {
            window.location.href = '{{ route("thank-you") }}';
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert(error.message || 'Une erreur est survenue lors de l\'envoi de vos réponses. Veuillez réessayer.');
        });
    });
    
    showStep(0);
});
</script>
@endsection
