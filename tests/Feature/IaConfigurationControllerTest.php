<?php

namespace Tests\Feature;

use App\Models\IaConfiguration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IaConfigurationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_configuration_with_process_name(): void
    {
        $response = $this->postJson('/api/ia-configuration', [
            'model' => 'llama3',
            'process_name' => 'text-generation',
            'prompt' => 'You are a helpful assistant.',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'model' => 'llama3',
            'process_name' => 'text-generation',
            'prompt' => 'You are a helpful assistant.',
        ]);

        $this->assertDatabaseHas('ia_configuration', [
            'process_name' => 'text-generation',
        ]);
    }

    public function test_cannot_create_configuration_with_job_key(): void
    {
        $response = $this->postJson('/api/ia-configuration', [
            'model' => 'llama3',
            'job' => 'text-generation',
            'prompt' => 'You are a helpful assistant.',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('process_name');
    }

    public function test_can_update_configuration_with_process_name(): void
    {
        $config = IaConfiguration::create([
            'model' => 'llama3',
            'process_name' => 'old-name',
            'prompt' => 'Old prompt.',
            'status' => 'active',
        ]);

        $response = $this->putJson("/api/ia-configuration/{$config->id}", [
            'model' => 'mistral',
            'process_name' => 'new-name',
            'prompt' => 'New prompt.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ia_configuration', [
            'id' => $config->id,
            'process_name' => 'new-name',
        ]);
    }
}
