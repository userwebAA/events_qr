<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\ResponseHistory;
use App\Models\Comment;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('order', 'asc')->get();

        // Calculer les statistiques pour chaque question
        $stats = [];
        foreach ($questions as $question) {
            $totalResponses = ResponseHistory::where('question_id', $question->id)->count();
            if ($totalResponses > 0) {
                $optionStats = [];
                foreach ($question->options as $option) {
                    $count = ResponseHistory::where('question_id', $question->id)
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

        return view('admin.questions.index', compact('questions', 'stats'));
    }

    public function update(Request $request, Question $question)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string|max:255',
                'options' => 'required|array|min:2',
                'options.*' => 'required|string|max:100'
            ]);

            $question->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Question mise à jour avec succès',
                'question' => $question
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la question: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string|max:255',
                'options' => 'required|array|min:2',
                'options.*' => 'required|string|max:100'
            ]);

            $maxOrder = Question::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;

            $question = Question::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Question créée avec succès',
                'question' => $question
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la question: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Question $question)
    {
        try {
            // Supprimer d'abord les réponses associées
            ResponseHistory::where('question_id', $question->id)->delete();
            Response::where('question_id', $question->id)->delete();

            // Supprimer la question
            $question->delete();

            // Réorganiser les ordres des questions restantes
            $questions = Question::orderBy('order')->get();
            foreach ($questions as $index => $q) {
                $q->update(['order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Question supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la question: ' . $e->getMessage()
            ], 500);
        }
    }

    public function move(Request $request, Question $question)
    {
        try {
            $validated = $request->validate([
                'direction' => 'required|in:up,down'
            ]);

            $currentOrder = $question->order;
            $direction = $validated['direction'];

            if ($direction === 'up' && $currentOrder > 1) {
                $otherQuestion = Question::where('order', $currentOrder - 1)->first();
                if ($otherQuestion) {
                    $otherQuestion->update(['order' => $currentOrder]);
                    $question->update(['order' => $currentOrder - 1]);
                }
            } elseif ($direction === 'down') {
                $otherQuestion = Question::where('order', $currentOrder + 1)->first();
                if ($otherQuestion) {
                    $otherQuestion->update(['order' => $currentOrder]);
                    $question->update(['order' => $currentOrder + 1]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Question déplacée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du déplacement de la question: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $validated = $request->validate([
                'questionId' => 'required|integer|exists:questions,id',
                'newOrder' => 'required|integer|min:1'
            ]);

            $question = Question::findOrFail($validated['questionId']);
            $oldOrder = $question->order;
            $newOrder = $validated['newOrder'];

            if ($oldOrder === $newOrder) {
                return response()->json(['success' => true]);
            }

            \DB::transaction(function () use ($question, $oldOrder, $newOrder) {
                if ($oldOrder < $newOrder) {
                    Question::where('order', '>', $oldOrder)
                           ->where('order', '<=', $newOrder)
                           ->decrement('order');
                } else {
                    Question::where('order', '>=', $newOrder)
                           ->where('order', '<', $oldOrder)
                           ->increment('order');
                }

                $question->update(['order' => $newOrder]);
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la réorganisation des questions: ' . $e->getMessage());
            return response()->json(['message' => 'Une erreur est survenue lors de la réorganisation des questions'], 500);
        }
    }

    public function resetOrder()
    {
        try {
            \DB::transaction(function () {
                $questions = Question::orderBy('order', 'asc')->get();
                foreach ($questions as $index => $question) {
                    $question->update(['order' => $index + 1]);
                }
            });

            return redirect()->route('admin.questions.index')->with('success', 'Ordre des questions réinitialisé');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la réinitialisation de l\'ordre: ' . $e->getMessage());
            return redirect()->route('admin.questions.index')->with('error', 'Une erreur est survenue lors de la réinitialisation de l\'ordre');
        }
    }

    public function updateOrder(Request $request, Question $question)
    {
        try {
            $validated = $request->validate([
                'order' => 'required|integer|min:1'
            ]);

            $newOrder = $validated['order'];
            $oldOrder = $question->order;

            if ($newOrder === $oldOrder) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aucun changement nécessaire'
                ]);
            }

            // Réorganiser les autres questions
            if ($newOrder > $oldOrder) {
                Question::whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            } else {
                Question::whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            }

            $question->update(['order' => $newOrder]);

            return response()->json([
                'success' => true,
                'message' => 'Ordre mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'ordre: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getResponses(Question $question)
    {
        try {
            $responses = ResponseHistory::where('question_id', $question->id)
                ->select('table_id', 'selected_option', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('table_id')
                ->map(function ($tableResponses) {
                    return $tableResponses->first();
                })
                ->values();

            return response()->json([
                'success' => true,
                'responses' => $responses,
                'question' => $question
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des réponses: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateResponses(Request $request, Question $question)
    {
        try {
            $validated = $request->validate([
                'responses' => 'required|array',
                'responses.*.table_id' => 'required|string',
                'responses.*.selected_option' => 'required|string'
            ]);

            foreach ($validated['responses'] as $response) {
                ResponseHistory::where('question_id', $question->id)
                    ->where('table_id', $response['table_id'])
                    ->update(['selected_option' => $response['selected_option']]);

                Response::where('question_id', $question->id)
                    ->where('table_id', $response['table_id'])
                    ->update(['selected_option' => $response['selected_option']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Réponses mises à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des réponses: ' . $e->getMessage()
            ], 500);
        }
    }
}
