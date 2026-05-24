<?php

namespace Database\Seeders;

use App\Models\IaConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IaConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            [
                'model' => 'llama3',
                'job' => 'text-generation',
                'prompt' => 'You are a helpful AI assistant. Respond clearly and concisely to all user queries.',
            ],
            [
                'model' => 'mistral',
                'job' => 'code-assistant',
                'prompt' => 'You are an expert programmer. Write clean, efficient code with clear explanations.',
            ],
            [
                'model' => 'gpt4all',
                'job' => 'summarization',
                'prompt' => 'Summarize the provided text in a clear and concise manner, capturing the key points.',
            ],
        ];

        foreach ($configs as $config) {
            IaConfiguration::create($config);
        }
    }
}