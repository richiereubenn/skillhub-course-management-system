<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'name' => 'Web Development Basics',
            'description' => 'Introduction to HTML, CSS, and JavaScript.',
            'schedule' => '2025-01-10 09:00:00',
            'instructor' => 'John Doe'
        ]);

        Course::create([
            'name' => 'Advanced Laravel',
            'description' => 'Understanding advanced backend development using Laravel.',
            'schedule' => '2025-01-15 14:00:00',
            'instructor' => 'Jane Smith'
        ]);

        Course::create([
            'name' => 'UI/UX Design Fundamentals',
            'description' => 'Learning Figma and design principles.',
            'schedule' => '2025-01-20 10:00:00',
            'instructor' => 'Michael Andrew'
        ]);
    }
}
