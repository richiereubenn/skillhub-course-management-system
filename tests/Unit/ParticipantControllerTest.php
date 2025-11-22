<?php

namespace Tests;

use Tests\TestCase;
use App\Models\Participant;
use App\Http\Controllers\ParticipantController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_success()
    {
        $controller = new ParticipantController();
        $request = Request::create('/participants', 'POST', [
            'name' => 'John Doe',
            'phone' => '08123456789',
            'email' => 'john@example.com',
            'address' => 'Jl. Example',
        ]);

        $controller->store($request);

        $this->assertDatabaseHas('participants', ['email' => 'john@example.com']);
    }

    public function test_store_fail_invalid_data()
    {
        $controller = new ParticipantController();
        $request = Request::create('/participants', 'POST', [
            'name' => '',
            'phone' => 'abc',
            'email' => 'notemail',
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->store($request);
    }

    public function test_update_success()
    {
        $participant = Participant::factory()->create();
        $controller = new ParticipantController();
        $request = Request::create("/participants/{$participant->id}", 'PUT', [
            'name' => 'Updated Name',
            'phone' => $participant->phone,
            'email' => $participant->email,
            'address' => $participant->address,
        ]);

        $controller->update($request, $participant);

        $this->assertDatabaseHas('participants', ['name' => 'Updated Name']);
    }

    public function test_update_fail_duplicate_email()
    {
        $p1 = Participant::factory()->create(['email' => 'a@example.com']);
        $p2 = Participant::factory()->create(['email' => 'b@example.com']);

        $controller = new ParticipantController();
        $request = Request::create("/participants/{$p2->id}", 'PUT', [
            'name' => 'New Name',
            'phone' => $p2->phone,
            'email' => 'a@example.com', // duplicate
            'address' => $p2->address,
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->update($request, $p2);
    }

    public function test_destroy_success()
    {
        $participant = Participant::factory()->create();
        $controller = new ParticipantController();

        $controller->destroy(participant: $participant);

        $this->assertDatabaseMissing('participants', ['id' => $participant->id]);
    }
}
