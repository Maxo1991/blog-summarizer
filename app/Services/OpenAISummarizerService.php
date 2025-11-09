<?php

declare(strict_types=1);

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAISummarizerService
{
    /**
     * Summarizes the given text using OpenAI GPT model.
     * Sends the input text to OpenAI and returns a short summary.
     *
     * @param string $text 
     * @return string
     * @throws \Exception 
     */
    public function summarize(string $text): string
    {
        try {
            $prompt = "Summarize the following text in a few sentences:\n\n" . $text;

            $response = OpenAI::responses()->create([
                'model' => 'gpt-4o-mini',
                'input' => $prompt,
            ]);

            $summary = $response->output_text ?? 'No summary generated.';
            
            Log::info('Received summary from OpenAI', ['summary_length' => strlen($summary)]);

            return $summary;
        } catch (\Exception $e) {
            Log::error('OpenAI summarization failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
