<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function store_success()
    {
        $response = $this->post('/courses', [
            'name' => 'Laravel 101',
            'description' => 'Intro',
            'schedule' => '2025-12-01',
            'instructor' => 'Jane Doe',
        ]);

        $response->assertStatus(302); 
        $this->assertDatabaseHas('courses', ['name' => 'Laravel 101']);
    }

    #[Test]
    public function store_fail_invalid_schedule()
    {
        $response = $this->post('/courses', [
            'name' => 'Laravel 101',
            'description' => 'Intro',
            'schedule' => 'invalid-date',
            'instructor' => 'Jane Doe',
        ]);

        $response->assertSessionHasErrors(['schedule']);
    }

    #[Test]
    public function store_fail_empty_name()
    {
        $response = $this->post('/courses', [
            'name' => '',
            'description' => 'Intro',
            'schedule' => '2025-12-01',
            'instructor' => 'Jane Doe',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function update_success()
    {
        $course = Course::factory()->create();

        $response = $this->put("/courses/{$course->id}", [
            'name' => 'Updated Course',
            'description' => $course->description,
            'schedule' => $course->schedule,
            'instructor' => $course->instructor,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('courses', ['name' => 'Updated Course']);
    }

    #[Test]
    public function update_fail_invalid_schedule()
    {
        $course = Course::factory()->create();

        $response = $this->put("/courses/{$course->id}", [
            'name' => 'Updated Course',
            'schedule' => 'invalid-date',
            'description' => $course->description,
            'instructor' => $course->instructor,
        ]);

        $response->assertSessionHasErrors(['schedule']);
    }

    #[Test]
    public function destroy_success()
    {
        $course = Course::factory()->create();

        $response = $this->delete("/courses/{$course->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
