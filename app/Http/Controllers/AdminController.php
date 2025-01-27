<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Question;
use App\Support\StreamMacLines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $perPage = 5;
        $sort = request()->get('sort', 'desc');

        // Cache des questions pour 1 heure
        $questions = Cache::remember('questions', 3600, function () {
            return Question::orderBy('id')->get();
        });

        // Optimisation des requêtes avec eager loading et pagination
        $responses = Response::select('id', 'answers', 'created_at', 'feedback')
            ->when($sort === 'asc', function($query) {
                return $query->oldest();
            }, function($query) {
                return $query->latest();
            })
            ->paginate($perPage);

        // Pour les statistiques, on prend toutes les réponses
        $allResponses = Response::select('id', 'answers')->get();

        // Si c'est une requête AJAX, renvoyer seulement le HTML des réponses
        if (request()->ajax()) {
            return response()->json([
                'html' => view('admin.partials.response-rows', [
                    'responses' => $responses,
                    'questions' => $questions
                ])->render(),
                'hasMore' => $responses->hasMorePages()
            ]);
        }

        // Calcul optimisé des statistiques
        $stats = $this->calculateStats($questions, $allResponses);

        return view('admin.index', compact('responses', 'questions', 'stats'));
    }

    private function calculateStats($questions, $responses)
    {
        $stats = [];
        $totalResponses = $responses->count();

        foreach ($questions as $question) {
            $optionCounts = array_count_values(
                $responses->pluck('answers.' . $question->id)->filter()->toArray()
            );

            $stats[$question->id] = [
                'total' => $totalResponses,
                'options' => collect($question->options)->map(function($option, $index) use ($optionCounts, $totalResponses) {
                    $count = $optionCounts[$index] ?? 0;
                    return [
                        'count' => $count,
                        'percentage' => $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0
                    ];
                })->toArray()
            ];
        }

        return $stats;
    }

    public function cleanInvalidResponses()
    {
        $questions = Question::all();
        $responses = Response::all();

        foreach ($responses as $response) {
            $isValid = true;
            foreach ($response->answers as $questionId => $answer) {
                $question = $questions->find($questionId);
                if (!$question || !isset($question->options[$answer])) {
                    $isValid = false;
                    break;
                }
            }
            if (!$isValid) {
                $response->delete();
            }
        }

        return redirect()->route('admin.index')->with('success', 'Les réponses invalides ont été supprimées.');
    }

    public function export()
    {
        $questions = Question::orderBy('id')->get();
        $responses = Response::latest()->get();

        $format = request()->get('format', 'windows');
        $filename = 'responses_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function() use ($questions, $responses, $format) {
            // Ajouter le BOM UTF-8 pour Excel
            echo "\xEF\xBB\xBF";

            $output = fopen('php://output', 'w');

            // Configurer le séparateur et les fins de ligne selon le format
            if ($format === 'mac') {
                stream_filter_register('mac_lines', StreamMacLines::class);
                stream_filter_append($output, 'mac_lines');
            }

            // En-têtes
            $headers = ['Date'];
            foreach ($questions as $question) {
                $headers[] = $question->question;
            }
            $headers[] = 'Commentaire';
            fputcsv($output, $headers);

            // Données
            foreach ($responses as $response) {
                $row = [
                    $response->created_at->format('d/m/Y H:i')
                ];

                foreach ($questions as $question) {
                    if (isset($response->answers[$question->id]) &&
                        isset($question->options[$response->answers[$question->id]])) {
                        $row[] = $question->options[$response->answers[$question->id]];
                    } else {
                        $row[] = '-';
                    }
                }

                $row[] = $response->feedback ?? '';
                fputcsv($output, $row);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
