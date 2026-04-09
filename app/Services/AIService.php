<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    private function callAI($prompt)
    {
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return [
                'success' => false,
                'error' => 'Gemini API key not found'
            ];
        }

        $response = Http::timeout(30)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey,
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'      => 0.2,
                    'responseMimeType' => 'application/json',
                ]
            ]
        );

        $data = $response->json();

        if (isset($data['error'])) {
            return [
                'success' => false,
                'error' => $data['error']['message'] ?? 'Gemini error',
                'raw' => $data
            ];
        }

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            return [
                'success' => false,
                'error' => 'Empty Gemini response',
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