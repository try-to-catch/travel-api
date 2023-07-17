<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTravelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_to_adding_travel(): void
    {
        $response = $this->postJson('/api/v1/admin/travels/');
        $response->assertUnauthorized();
    }

    public function test_non_admin_user_cannot_access_to_adding_travel(): void
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels/');
        $response->assertForbidden();
    }


    public function test_saves_travels_successfully_with_valid_data(): void
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
            'name' => 'Travel name',
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels/', [
            'name' => 'Travel name',
            'description' => 'Travel description',
            'number_of_days' => 5,
            'is_public' => true,
        ]);

        $response->assertCreated();
        $response->assertJsonFragment(['name' => 'Travel name']);
    }
}
