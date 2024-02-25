<?php

namespace Tests\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=TestSeeder');
    }
    #[DataProvider('providerCourses')]
    public function testCoursePages(string $uri, int $assertStatus): void
    {
        $response = $this->get($uri);
        $response->assertStatus($assertStatus);
    }

    public static function providerCourses(): array
    {
        return [
            'coursesList' => [
                'uri' => '/courses',
                'assertStatus' => 200,
            ],
            'coursesSingle' => [
                'uri' => '/courses/1',
                'assertStatus' => 200,
            ],
        ];
    }

    public function testCourseAddStudent(): void
    {
        $studentId = 1;
        $courseId = 2;

        $response = $this->post('/courses/' . $courseId . '/add-student', ['studentId' => $studentId]);
        $response->assertStatus(302);

        $student = Student::find($studentId);
        $this->assertSame(2, $student->courses()->count());
    }

    public function testCourseRemoveStudent(): void
    {
        $studentId = 2;
        $courseId = 2;

        $response = $this->delete('/courses/' . $courseId . '/remove-student', ['studentId' => $studentId]);
        $response->assertStatus(302);

        $student = Student::find($studentId);
        $this->assertSame(0, $student->courses()->count());
    }
}
