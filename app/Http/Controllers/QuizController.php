<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QuizController extends Controller
{
    public function show()
    {
        $questions = Question::orderBy('id')->get();
        
        if ($questions->isEmpty()) {
            Log::warning('Aucune question trouvée dans la base de données');
            return redirect()->route('home')->with('error', 'Le questionnaire n\'est pas disponible pour le moment.');
        }

        return view('quiz.show', compact('questions'));
    }

    public function submit(Request $request)
    {
        try {
            Log::info('Données reçues:', $request->json()->all());
            
            // Récupérer les données JSON
            $data = $request->json()->all();
            $answers = $data['answers'] ?? null;
            $feedback = $data['feedback'] ?? '';
            
            // Validation des données
            if (!is_array($answers) || empty($answers)) {
                throw new \Exception('Format de réponses invalide');
            }

            // Vérification que toutes les réponses correspondent à des questions existantes
            $questions = Question::pluck('id')->toArray();
            foreach ($answers as $questionId => $answer) {
                if (!in_array((int)$questionId, $questions)) {
                    throw new \Exception('Question invalide détectée');
                }
                if (!is_numeric($answer)) {
                    throw new \Exception('Format de réponse invalide');
                }
                // Convertir les réponses en entiers
                $answers[$questionId] = (int)$answer;
            }

            // Sauvegarder les réponses
            $response = Response::create([
                'answers' => json_encode($answers),
                'feedback' => $feedback
            ]);

            Log::info('Réponse créée avec succès:', ['id' => $response->id]);

            return response()->json([
                'success' => true,
                'message' => 'Réponses enregistrées avec succès',
                'redirect' => route('quiz.thank-you')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la soumission du questionnaire: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement de vos réponses: ' . $e->getMessage()
            ], 422);
        }
    }

    public function thankYou()
    {
        return view('quiz.thank-you');
    }
}
