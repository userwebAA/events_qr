<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\ResponseHistory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|string',
            'responses' => 'required|array',
            'responses.*.question_id' => 'required|integer',
            'responses.*.selected_option' => 'required|string',
            'feedback' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $now = now();

            // Sauvegarder les réponses aux questions
            foreach ($validated['responses'] as $response) {
                // Créer dans la table responses
                Response::create([
                    'question_id' => $response['question_id'],
                    'selected_option' => $response['selected_option'],
                    'table_id' => $validated['table_id']
                ]);

                // Créer dans la table response_history
                ResponseHistory::create([
                    'table_id' => $validated['table_id'],
                    'question_id' => $response['question_id'],
                    'selected_option' => $response['selected_option'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            // Sauvegarder le commentaire s'il existe
            if (!empty($validated['feedback'])) {
                // Créer dans la table responses
                Response::create([
                    'question_id' => null,
                    'selected_option' => 'Commentaire',
                    'table_id' => $validated['table_id'],
                    'feedback' => $validated['feedback']
                ]);

                // Créer dans la table response_history
                ResponseHistory::create([
                    'table_id' => $validated['table_id'],
                    'question_id' => null,
                    'selected_option' => 'Commentaire',
                    'feedback' => $validated['feedback'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Merci pour votre retour !']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Une erreur est survenue lors de l\'enregistrement.'], 500);
        }
    }
}
