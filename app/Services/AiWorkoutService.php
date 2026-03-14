<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;

class AiWorkoutService
{
    /**
     * Generate a customized workout plan based on user info.
     *
     * @param float $height User height in cm
     * @param float $weight User weight in kg
     * @param int $age User age
     * @return string
     */
    public function generateWorkout(float $height, float $weight, int $age): string
    {
        $prompt = "Generate a customized workout plan for a person with the following profile:
        - Height: {$height} cm
        - Weight: {$weight} kg
        - Age: {$age} years
        
        The workout should be balanced and safe. Format the response as a clear, structured workout plan text.";

        $response = Gemini::text()
            ->model('gemini-2.5-flash')
            ->system('You are a helpful fitness assistant.')
            ->prompt($prompt)
            ->temperature(0.7)
            ->maxTokens(1024)
            ->generate();

        return $response->content();
    }
}
