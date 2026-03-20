<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
   private function callAI($prompt)
    {
        $apiKey = env('OPENAI_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . trim($apiKey),
            'Content-Type' => 'application/json',
        ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
            "model" => "gpt-4o-mini",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a strict JSON generator. Always return valid JSON only."
                ],
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ],
            "temperature" => 0.3,
        ]);

        if (!$response->successful()) {
            return [
                'success' => false,
                'error' => 'AI request failed',
                'status' => $response->status(),
                'raw' => $response->json()
            ];
        }

        $data = $response->json();
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

        // إزالة ```json
        $text = preg_replace('/```json|```/', '', $text);

        // استخراج JSON
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
    - Return ONLY valid JSON
    - No text before or after
    - No markdown
    - Ensure EXACTLY {$meals} meals
    - Each meal must include: name, calories, protein, carbs, fat

    RESPONSE STRUCTURE:

    {
    \"total_calories\": 0,
    \"total_protein\": 0,
    \"total_carbs\": 0,
    \"total_fat\": 0,
    \"meals\": [
        {
        \"title\": \"Breakfast\",
        \"items\": [
            {
            \"name\": \"Oats\",
            \"calories\": 300,
            \"protein\": 10,
            \"carbs\": 50,
            \"fat\": 5
            }
        ],
        \"meal_calories\": 300
        }
    ]
    }
    ";

        return $this->callAI($prompt);
    }
}