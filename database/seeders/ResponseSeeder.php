<?php

namespace Database\Seeders;

use App\Models\Response;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ResponseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer quelques réponses de test
        $responses = [
            [
                'answers' => json_encode([
                    '1' => 0,
                    '2' => 1,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0
                ]),
                'feedback' => 'Excellent service, nous reviendrons !',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'answers' => json_encode([
                    '1' => 1,
                    '2' => 0,
                    '3' => 1,
                    '4' => 1,
                    '5' => 1
                ]),
                'feedback' => 'Très bonne expérience globale',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'answers' => json_encode([
                    '1' => 0,
                    '2' => 0,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0
                ]),
                'feedback' => 'Une soirée parfaite !',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($responses as $response) {
            Response::create($response);
        }
    }
}
