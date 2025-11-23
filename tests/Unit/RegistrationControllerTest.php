<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Participant;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function store_success()
    {
        $participant = Participant::factory()->create();
        $course = Course::factory()->create();

        $response = $this->post("/courses/{$course->id}/register", [
            'participant_id' => $participant->id,
            'registration_date' => '2025-12-01',
        ]);

        $response->assertStatus(302); 

        $this->assertDatabaseHas('registrations', [
            'course_id' => $course->id,
            'participant_id' => $participant->id,
        ]);
    }

    #[Test]
    public function store_fail_already_registered()
    {
        $participant = Participant::factory()->create();
        $course = Course::factory()->create();

        $course->participants()->attach($participant->id);

        $response = $this->post("/courses/{$course->id}/register", [
            'participant_id' => $participant->id,
        ]);

        $response->assertSessionHasErrors(['participant_id']);
        $this->assertEquals(1, $course->participants()->count());
    }

    #[Test]
    public function destroy_success()
    {
        $participant = Participant::factory()->create();
        $course = Course::factory()->create();
        
        $course->participants()->attach($participant->id);

        $response = $this->delete("/courses/{$course->id}/register/{$participant->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('registrations', [
            'course_id' => $course->id,
            'participant_id' => $participant->id,
        ]);
    }
}
