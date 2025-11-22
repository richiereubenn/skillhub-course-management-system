<?php

namespace Tests;

use Tests\TestCase;
use App\Models\Course;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_success(): void
    {
        $controller = new CourseController();
        $request = Request::create('/courses', 'POST', [
            'name' => 'Laravel 101',
            'description' => 'Intro',
            'schedule' => '2025-12-01',
            'instructor' => 'Jane Doe',
        ]);

        $controller->store($request);

        $this->assertDatabaseHas('courses', ['name' => 'Laravel 101']);
    }

    public function test_store_fail_invalid_schedule()
    {
        $controller = new CourseController();
        $request = Request::create('/courses', 'POST', [
            'name' => 'Laravel 101',
            'description' => 'Intro',
            'schedule' => 'invalid-date',
            'instructor' => 'Jane Doe',
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->store($request);
    }

    public function test_store_fail_empty_name()
    {
        $controller = new CourseController();
        $request = Request::create('/courses', 'POST', [
            'name' => '',
            'description' => 'Intro',
            'schedule' => '2025-12-01',
            'instructor' => 'Jane Doe',
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->store($request);
    }

    public function test_update_success()
    {
        $course = Course::factory()->create();
        $controller = new CourseController();
        $request = Request::create("/courses/{$course->id}", 'PUT', [
            'name' => 'Updated Course',
            'description' => $course->description,
            'schedule' => $course->schedule,
            'instructor' => $course->instructor,
        ]);

        $controller->update($request, $course);

        $this->assertDatabaseHas('courses', ['name' => 'Updated Course']);
    }

    public function test_update_fail_invalid_schedule()
    {
        $course = Course::factory()->create();
        $controller = new CourseController();
        $request = Request::create("/courses/{$course->id}", 'PUT', [
            'name' => 'Updated Course',
            'schedule' => 'invalid-date',
            'description' => $course->description,
            'instructor' => $course->instructor,
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->update($request, $course);
    }

    public function test_destroy_success()
    {
        $course = Course::factory()->create();
        $controller = new CourseController();

        $controller->destroy($course);

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}

