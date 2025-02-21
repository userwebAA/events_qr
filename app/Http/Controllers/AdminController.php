<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseHistory; // Ajouter l'utilisation du modèle ResponseHistory
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::orderBy('order')->get();
        $perPage = 5;

        // Obtenir le nombre total de réponses uniques
        $totalResponses = ResponseHistory::select('table_id', 'created_at')
            ->whereNotNull('table_id')
            ->groupBy('table_id', 'created_at')
            ->orderByDesc('created_at')
            ->get();

        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $offset = ($page - 1) * $perPage;

            // Récupérer la page demandée
            $responses = $totalResponses->slice($offset, $perPage);
            
            if ($responses->isEmpty()) {
                return response()->json([
                    'html' => '',
                    'hasMore' => false
                ]);
            }

            $tableIds = $responses->pluck('table_id');
            $dates = $responses->pluck('created_at');

            $responseDetails = ResponseHistory::whereIn('table_id', $tableIds)
                ->whereIn('created_at', $dates)
                ->whereNotNull('question_id')
                ->with('question')
                ->orderByDesc('created_at')
                ->get()
                ->groupBy(function($item) {
                    return $item->table_id . '_' . $item->created_at->format('Y-m-d H:i:s');
                });

            $feedbacks = ResponseHistory::whereIn('table_id', $tableIds)
                ->whereIn('created_at', $dates)
                ->whereNotNull('feedback')
                ->orderByDesc('created_at')
                ->get()
                ->groupBy(function($item) {
                    return $item->table_id . '_' . $item->created_at->format('Y-m-d H:i:s');
                });

            $html = view('admin.partials.response-rows', compact('responses', 'questions', 'responseDetails', 'feedbacks'))->render();
            
            return response()->json([
                'html' => $html,
                'hasMore' => ($offset + $perPage) < $totalResponses->count()
            ]);
        }

        // Chargement initial : prendre les 5 premières réponses
        $initialResponses = $totalResponses->take($perPage);
        
        $tableIds = $initialResponses->pluck('table_id');
        $dates = $initialResponses->pluck('created_at');

        $responseDetails = ResponseHistory::whereIn('table_id', $tableIds)
            ->whereIn('created_at', $dates)
            ->whereNotNull('question_id')
            ->with('question')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function($item) {
                return $item->table_id . '_' . $item->created_at->format('Y-m-d H:i:s');
            });

        $feedbacks = ResponseHistory::whereIn('table_id', $tableIds)
            ->whereIn('created_at', $dates)
            ->whereNotNull('feedback')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function($item) {
                return $item->table_id . '_' . $item->created_at->format('Y-m-d H:i:s');
            });

        $hasMore = $totalResponses->count() > $perPage;

        return view('admin.dashboard', compact(
            'initialResponses',
            'questions',
            'responseDetails',
            'feedbacks',
            'hasMore'
        ));
    }

    public function export()
    {
        $questions = Question::orderBy('order')->get();

        // Obtenir toutes les réponses uniques groupées par table et date
        $uniqueResponses = ResponseHistory::select('table_id', 'created_at')
            ->whereNotNull('table_id')
            ->groupBy('table_id', 'created_at')
            ->orderByDesc('created_at')
            ->get();

        // Récupérer toutes les réponses et feedbacks en une seule requête
        $allResponses = ResponseHistory::whereIn('table_id', $uniqueResponses->pluck('table_id'))
            ->whereIn('created_at', $uniqueResponses->pluck('created_at'))
            ->get();

        // Grouper les réponses par table_id et created_at
        $groupedResponses = $allResponses->groupBy(function($item) {
            return $item->table_id . '_' . $item->created_at->format('Y-m-d H:i:s');
        });

        // Préparer les en-têtes du CSV
        $headers = ['Table', 'Date'];
        foreach ($questions as $question) {
            $headers[] = $question->content;
        }
        $headers[] = 'Commentaire';

        $csvData = [$headers];

        // Pour chaque réponse unique
        foreach ($uniqueResponses as $uniqueResponse) {
            $key = $uniqueResponse->table_id . '_' . $uniqueResponse->created_at->format('Y-m-d H:i:s');
            $responses = $groupedResponses->get($key, collect());

            $row = [
                $uniqueResponse->table_id,
                $uniqueResponse->created_at->format('d/m/Y H:i')
            ];

            // Ajouter les réponses dans l'ordre des questions
            foreach ($questions as $question) {
                $answer = $responses->firstWhere('question_id', $question->id);
                $row[] = $answer ? $answer->selected_option : '-';
            }

            // Ajouter le feedback
            $feedback = $responses->whereNotNull('feedback')->first();
            $row[] = $feedback ? $feedback->feedback : '-';

            $csvData[] = $row;
        }

        $filename = 'responses_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Ajouter le BOM UTF-8 pour Excel
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row, ';'); // Utiliser le point-virgule comme séparateur pour Excel
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function cleanInvalidResponses()
    {
        try {
            $deleted = Response::whereNotIn('question_id', function($query) {
                $query->select('id')->from('questions');
            })->delete();

            return response()->json([
                'success' => true,
                'message' => $deleted . ' réponses invalides ont été supprimées.'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors du nettoyage des réponses : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du nettoyage des réponses.'
            ], 500);
        }
    }

    public function history($tableId)
    {
        $questions = Question::orderBy('order')->get();
        
        $responses = ResponseHistory::where('table_id', $tableId)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.response-history', compact('responses', 'questions', 'tableId'));
    }
}
