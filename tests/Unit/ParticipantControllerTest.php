<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_store_success()
    {
        $response = $this->post('/participants', [
            'name' => 'John Doe',
            'phone' => '08123456789',
            'email' => 'john@example.com',
            'address' => 'Jl. Example',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('participants', ['email' => 'john@example.com']);
    }

    #[Test]
    public function test_store_fail_empty_name()
    {
        $response = $this->post('/participants', [
            'name' => '',
            'phone' => '08123456789',
            'email' => 'john@example.com',
            'address' => 'Jl. Example',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function test_store_fail_invalid_email()
    {
        $response = $this->post('/participants', [
            'name' => 'john',
            'phone' => '08123456789',
            'email' => 'john', 
            'address' => 'Jl. Example',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function test_update_success()
    {
        $participant = Participant::factory()->create();

        $response = $this->put("/participants/{$participant->id}", [
            'name' => 'Updated Name',
            'phone' => $participant->phone,
            'email' => $participant->email,
            'address' => $participant->address,
        ]);

        $response->assertStatus(302);  
        $this->assertDatabaseHas('participants', ['name' => 'Updated Name']);
    }

    #[Test]
    public function test_update_fail_duplicate_email()
    {
        $p1 = Participant::factory()->create(['email' => 'a@example.com']);
        $p2 = Participant::factory()->create(['email' => 'b@example.com']);

        $response = $this->put("/participants/{$p2->id}", [
            'name' => 'New Name',
            'phone' => $p2->phone,
            'email' => 'a@example.com', 
            'address' => $p2->address,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function test_destroy_success()
    {
        $participant = Participant::factory()->create();

        $response = $this->delete("/participants/{$participant->id}");

        $response->assertStatus(302); // redirect expected
        $this->assertDatabaseMissing('participants', ['id' => $participant->id]);
    }
}
