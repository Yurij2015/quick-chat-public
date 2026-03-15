<?php

namespace Tests\Feature;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ChatAppTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_dashboard_requires_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_can_get_messages(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Message::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'text' => 'Hello from user 1',
        ]);

        $this->actingAs($user1);

        $response = $this->getJson("/messages/{$user2->id}");

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.text', 'Hello from user 1');
    }

    public function test_can_send_message(): void
    {
        Event::fake();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1);

        $response = $this->postJson('/messages', [
            'receiver_id' => $user2->id,
            'text' => 'Test message',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('messages', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'text' => 'Test message',
        ]);

        Event::assertDispatched(MessageSent::class);
    }
}
