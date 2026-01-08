<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsUser($abilities = ['*']): User
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, $abilities);
        return $user;
    }

    public function test_user_can_create_item()
    {
        $this->actingAsUser();

        $payload = [
            'name' => 'Test Item',
            'description' => 'This is a test item',
            'code' => 'TEST-001',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/items', $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Test Item',
                'code' => 'TEST-001',
                'status' => 'active',
            ]);

        $this->assertDatabaseHas('items', [
            'code' => 'TEST-001',
        ]);
    }

    public function test_code_must_be_unique()
    {
        $this->actingAsUser();

        // Create an existing item
        Item::factory()->create(['code' => 'DUPLICATE']);

        $response = $this->postJson('/api/items', [
            'name' => 'Another Item',
            'code' => 'DUPLICATE',
            'status' => 'active',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }

    public function test_user_can_list_items()
    {
        $this->actingAsUser();

        Item::factory()->count(3)->create();

        $response = $this->getJson('/api/items');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_update_item()
    {
        $this->actingAsUser();

        $item = Item::factory()->create(['status' => 'inactive']);

        $response = $this->putJson("/api/items/{$item->id}", [
            'name' => $item->name,
            'code' => $item->code,
            'status' => 'active',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => 'active',
        ]);
    }

    public function test_user_can_delete_item()
    {
        $this->actingAsUser();

        $item = Item::factory()->create();

        $response = $this->deleteJson("/api/items/{$item->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('items', [
            'id' => $item->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_items()
    {
        $response = $this->getJson('/api/items');

        $response->assertStatus(401);
    }
}
