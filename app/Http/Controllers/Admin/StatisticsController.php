<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('order', 'asc')->get();

        // Calculer les statistiques pour chaque question
        $stats = [];
        foreach ($questions as $question) {
            $totalResponses = Response::where('question_id', $question->id)->count();
            if ($totalResponses > 0) {
                $optionStats = [];
                foreach ($question->options as $option) {
                    $count = Response::where('question_id', $question->id)
                        ->where('selected_option', $option)
                        ->count();
                    $percentage = round(($count / $totalResponses) * 100, 1);
                    $optionStats[$option] = [
                        'count' => $count,
                        'percentage' => $percentage
                    ];
                }
                $stats[$question->id] = [
                    'total' => $totalResponses,
                    'options' => $optionStats
                ];
            }
        }

        // Récupérer les 3 derniers commentaires
        $latestComments = Response::whereNotNull('feedback')
            ->where('feedback', '!=', '')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('admin.statistics.index', compact('questions', 'stats', 'latestComments'));
    }
}
