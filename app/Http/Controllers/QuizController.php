<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function showQr()
    {
        $url = route('quiz.show');
        $qrCode = QrCode::size(300)
                        ->backgroundColor(255, 255, 255)
                        ->color(0, 0, 0)
                        ->margin(2)
                        ->generate($url);

        return view('quiz.qr', compact('qrCode'));
    }

    public function show($tableId = null)
    {
        $questions = Question::orderBy('order', 'asc')->get();
        return view('quiz.show', compact('questions', 'tableId'));
    }

    public function submit(Request $request)
    {
        try {
            $data = $request->json()->all();
            Log::info('Données reçues:', $data);

            if (!isset($data['answers']) || !is_array($data['answers'])) {
                throw new \Exception('Format de réponses invalide');
            }

            $answers = $data['answers'];
            $feedback = $data['feedback'] ?? '';
            $tableId = $data['tableId'] ?? null;

            DB::beginTransaction();

            foreach ($answers as $questionId => $selectedOption) {
                // Créer la réponse normale
                $response = Response::create([
                    'question_id' => $questionId,
                    'selected_option' => $selectedOption,
                    'table_id' => $tableId,
                    'feedback' => $feedback
                ]);

                // Sauvegarder dans l'historique
                ResponseHistory::create([
                    'question_id' => $questionId,
                    'selected_option' => $selectedOption,
                    'table_id' => $tableId,
                    'feedback' => $feedback
                ]);

                Log::info('Réponse enregistrée:', [
                    'question_id' => $questionId,
                    'selected_option' => $selectedOption,
                    'table_id' => $tableId
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Réponses enregistrées avec succès',
                'redirect' => route('thank-you')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la soumission:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue : ' . $e->getMessage()
            ], 500);
        }
    }

    public function thankYou()
    {
        return view('quiz.thank-you');
    }
}
