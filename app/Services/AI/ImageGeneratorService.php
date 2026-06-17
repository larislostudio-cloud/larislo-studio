<?php

namespace App\Services\AI;

// ImageGeneratorService.php
class ImageGeneratorService
{
    protected $openAI;
    protected $promptBuilder;

    public function __construct(OpenAIService $openAI, PromptBuilderService $promptBuilder)
    {
        $this->openAI = $openAI;
        $this->promptBuilder = $promptBuilder;
    }

    public function generate(string $description): ?string
    {
        $enhancedPrompt = $this->promptBuilder->buildImagePrompt($description);
        return $this->openAI->generateImage($enhancedPrompt);
    }
}

