<?php

namespace App\Services\AI;

class CaptionGeneratorService
{
    protected $openAI;
    protected $promptBuilder;

    public function __construct(OpenAIService $openAI, PromptBuilderService $promptBuilder)
    {
        $this->openAI = $openAI;
        $this->promptBuilder = $promptBuilder;
    }

    public function generate(array $data): string
    {
        // 1. Bangun Prompt
        $prompt = $this->promptBuilder->buildCaptionPrompt($data);

        // 2. Panggil AI
        $result = $this->openAI->chat($prompt);

        return $result ?? 'Maaf, gagal membuat caption saat ini.';
    }
}
