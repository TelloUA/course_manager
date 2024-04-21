<?php

namespace Tests\Http\Controllers;

use App\Models\Student;
use Database\Seeders\TestSeeder;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->seeder = TestSeeder::class;
        parent::setUp();
    }
    #[DataProvider('providerStudents')]
    public function testStudentsPages(string $uri, int $assertStatus): void
    {
        $response = $this->get($uri);
        $response->assertStatus($assertStatus);
    }

    public static function providerStudents(): array
    {
        return [
            'listPage' => [
                'uri' => '/students',
                'assertStatus' => 200,
            ],
            'addPage' => [
                'uri' => '/student-add',
                'assertStatus' => 200,
            ],
            'personalPage' => [
                'uri' => '/student/1',
                'assertStatus' => 200,
            ],
        ];
    }

    public function testCreateStudent(): void
    {
        $data = [
            'firstName' => 'Boris',
            'lastName' => 'Johnson',
            'groupId' => 1,
        ];

        $response = $this->post('/student-save', $data);
        $response->assertStatus(302);

        $student = Student::where('first_name', 'Boris')->where('last_name', 'Johnson')->first();
        $this->assertInstanceOf(Student::class, $student);
        $this->assertSame($student->group_id, $data['groupId']);
    }

    public function testDeleteStudent(): void
    {
        $studentId = 2;

        $response = $this->delete('/student/' . $studentId);
        $response->assertStatus(302);

        $this->assertNull(Student::find($studentId));
    }
}
