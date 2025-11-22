<?php

namespace Tests;

use Tests\TestCase;
use App\Models\Participant;
use App\Models\Course;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_success()
    {
        $participant = Participant::factory()->create();
        $course = Course::factory()->create();

        $controller = new RegistrationController();
        $request = Request::create("/courses/{$course->id}/register", 'POST', [
            'participant_id' => $participant->id,
            'registration_date' => '2025-12-01',
        ]);

        $controller->store($request, $course);

        $this->assertDatabaseHas('registrations', [
            'course_id' => $course->id,
            'participant_id' => $participant->id,
        ]);
    }

    public function test_store_fail_already_registered()
    {
        $participant = Participant::factory()->create();
        $course = Course::factory()->create();
        $course->participants()->attach($participant->id);

        $controller = new RegistrationController();
        $request = new Request([
            'participant_id' => $participant->id
        ]);

        $response = $controller->store($request, $course);

        $errors = $response->getSession()->get('errors')->getBag('default')->getMessages();
        $this->assertArrayHasKey('participant_id', $errors);

        $this->assertEquals(1, $course->participants()->count());
    }


    public function test_destroy_success()
    {
        $participant = Participant::factory()->create();
        $course = Course::factory()->create();
        $course->participants()->attach($participant->id);

        $controller = new RegistrationController();
        $controller->destroy($course, $participant);

        $this->assertDatabaseMissing('registrations', [
            'course_id' => $course->id,
            'participant_id' => $participant->id,
        ]);
    }
}

