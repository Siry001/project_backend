<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    private function callAI($prompt)
    {
        $apiKey = env('OPENROUTER_API_KEY');

        if (!$apiKey) {
            return [
                'success' => false,
                'error' => 'API key not found'
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . trim($apiKey),
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            "model" => "mistralai/mixtral-8x7b-instruct",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a strict JSON generator. Output ONLY valid JSON."
                ],
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ],
            "temperature" => 0.2
        ]);

        $data = $response->json();

        if (isset($data['error'])) {
            return [
                'success' => false,
                'error' => $data['error']['message'] ?? 'AI error',
                'raw' => $data
            ];
        }

        $text = $data['choices'][0]['message']['content'] ?? null;

        if (!$text) {
            return [
                'success' => false,
                'error' => 'Empty AI response',
                'raw' => $data
            ];
        }

        return $this->parseJson($text);
    }

    private function parseJson($text)
    {
        $text = trim($text);

        // remove markdown
        $text = preg_replace('/```json|```/', '', $text);

        // extract JSON
        preg_match('/\{.*\}/s', $text, $matches);
        $jsonString = $matches[0] ?? null;

        if (!$jsonString) {
            return [
                'success' => false,
                'error' => 'No JSON found',
                'raw' => $text
            ];
        }

        $cleanJson = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'error' => 'Invalid JSON format',
                'raw' => $jsonString
            ];
        }

        return [
            'success' => true,
            'data' => $cleanJson
        ];
    }

    // ================= WORKOUT =================

    public function generateWorkout($goal, $level, $days)
    {
        $prompt = "
        Generate a {$days}-day workout plan.

        Goal: {$goal}
        Level: {$level}

        STRICT RULES:
        - Return ONLY pure JSON
        - No text, no explanation

        Format:
        {
          \"plan\": [
            {
              \"day\": \"Day 1\",
              \"exercises\": [
                {
                  \"name\": \"Bench Press\",
                  \"sets\": 4,
                  \"reps\": 10
                }
              ]
            }
          ]
        }
        ";

        return $this->callAI($prompt);
    }

    // ================= DIET =================

    public function generateDiet($goal, $weight, $meals)
    {
        $prompt = "
        Generate a {$meals}-meal diet plan.

        Goal: {$goal}
        Weight: {$weight} kg

        STRICT RULES:
        - Return ONLY pure JSON
        - No text, no explanation

        Format:
        {
          \"diet\": [
            {
              \"meal\": \"Breakfast\",
              \"foods\": [
                {
                  \"name\": \"Oats\",
                  \"calories\": 300
                }
              ]
            }
          ]
        }
        ";

        return $this->callAI($prompt);
    }
}