<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question' => 'Comment avez-vous trouvé la qualité de nos plats ?',
                'options' => ['Excellent', 'Très bien', 'Bien', 'Peut mieux faire'],
                'correct_answer' => 0
            ],
            [
                'question' => 'Le service était-il à la hauteur de vos attentes ?',
                'options' => ['Parfait', 'Très satisfaisant', 'Satisfaisant', 'À améliorer'],
                'correct_answer' => 0
            ],
            [
                'question' => 'Comment jugez-vous l\'ambiance du restaurant ?',
                'options' => ['Très agréable', 'Agréable', 'Correcte', 'À revoir'],
                'correct_answer' => 0
            ],
            [
                'question' => 'Le rapport qualité-prix vous semble-t-il justifié ?',
                'options' => ['Tout à fait', 'Plutôt oui', 'Moyen', 'Non'],
                'correct_answer' => 0
            ],
            [
                'question' => 'Recommanderiez-vous notre restaurant ?',
                'options' => ['Certainement', 'Probablement', 'Peut-être', 'Pas pour le moment'],
                'correct_answer' => 0
            ]
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
