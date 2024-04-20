<?php

namespace Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Database\Seeders\TestApiCourseSeeder;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ApiCourseControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->seeder = TestApiCourseSeeder::class;
        parent::setUp();
    }

    #[DataProvider('providerCoursePages')]
    public function testCoursePages(string $uri, int $assertStatus, array $expected): void
    {
        $response = $this->get($uri);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);
        $this->assertSame($expected, $content['data']);
    }

    public static function providerCoursePages(): \Generator
    {
        $baseUri = '/api/v1/courses';

        yield 'list' => [
            'uri' => $baseUri,
            'assertStatus' => 200,
            'expected' => [
                [
                    'id' => 1,
                    'name' => 'math',
                    'description' => 'some algebra and geometry',
                    'count' => 2,
                ],
                [
                    'id' => 2,
                    'name' => 'literature',
                    'description' => 'some good books',
                    'count' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'geography',
                    'description' => 'some info about lands',
                    'count' => 0,
                ],
            ],
        ];
        yield 'one' => [
            'uri' => $baseUri . '/1',
            'assertStatus' => 200,
            'expected' => [
                'id' => 1,
                'name' => 'math',
                'description' => 'some algebra and geometry',
                'students' => [
                    [
                        'id' => 1,
                        'name' => 'Name1 Surname1',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Name2 Surname2',
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('providerCourseAddStudents')]
    public function testCourseAddStudents(string $uri, array $params, int $assertStatus, array $expected): void
    {
        $response = $this->post($uri, $params);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);

        if ($assertStatus === 204) {
            $student = Student::find($expected['studentId']);
            $ids = $student->courses->map(function ($course) {
                return $course->id;
            })->all();
            $this->assertSame($expected['coursesIds'], $ids);
            $group = Course::find($expected['coursesIds'][0]);
            $this->assertSame(1, $group->students->count());
        } else {
            $this->assertSame($expected, $content);
        }
    }

    public static function providerCourseAddStudents(): \Generator
    {
        $baseUri = '/api/v1/courses/';
        yield 'success' => [
            'uri' => $baseUri . '3/add-student',
            'params' => ['studentId' => '3'],
            'assertStatus' => 204,
            'expected' => [
                'coursesIds' => [3],
                'studentId' => 3,
            ],
        ];
        yield 'noCourse' => [
            'uri' => $baseUri . '299/add-student',
            'params' => ['studentId' => '3'],
            'assertStatus' => 422,
            'expected' => ['errors' => 'No such course'],
        ];
        yield 'noStudent' => [
            'uri' => $baseUri . '3/add-student',
            'params' => ['studentId' => '299'],
            'assertStatus' => 422,
            'expected' => [
                'errors' => [
                    'studentId' => ['The selected student id is invalid.'],
                ],
            ],
        ];
    }

    #[DataProvider('providerCourseRemoveStudent')]
    public function testCourseRemoveStudent(
        string $uri,
        array $params,
        int $assertStatus,
        ?array $expected,
        array $expectedCourses
    ): void {
        $response = $this->delete($uri, $params);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);

        $this->assertSame($expected, $content);

        if (($student = Student::find($params['studentId'])) instanceof Student) {
            $this->assertEquals($expectedCourses, $student->courses->modelKeys());
        }
    }

    public static function providerCourseRemoveStudent(): \Generator
    {
        $baseUri = 'api/v1/courses/';
        yield 'success' => [
            'uri' => $baseUri . '1/remove-student',
            'params' => ['studentId' => '2'],
            'assertStatus' => 204,
            'expected' => null,
            'expectedCourses' => [2],
        ];
        yield 'noCourse' => [
            'uri' => $baseUri . '299/remove-student',
            'params' => ['studentId' => '2'],
            'assertStatus' => 422,
            'expected' => ['errors' => "No such course"],
            'expectedCourses' => [1,2],
        ];
        yield 'noStudent' => [
            'uri' => $baseUri . '1/remove-student',
            'params' => ['studentId' => '299'],
            'assertStatus' => 422,
            'expected' => [
                'errors' => [
                    'studentId' => ['The selected student id is invalid.'],
                ],
            ],
            'expectedCourses' => [],
        ];
    }
}
