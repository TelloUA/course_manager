<?php

namespace Http\Controllers;

use App\Models\Student;
use Database\Seeders\TestApiStudentSeeder;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ApiStudentControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->seeder = TestApiStudentSeeder::class;
        parent::setUp();
    }

    #[DataProvider('providerStudentsPages')]
    public function testStudentsPages(string $uri, int $assertStatus, array $expectedResult): void
    {
        $response = $this->get($uri);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);
        $this->assertSame($expectedResult, $content['data']);
    }

    public static function providerStudentsPages(): \Generator
    {
        $baseRoute = '/api/v1/students';

        yield 'list' => [
            'uri' => $baseRoute,
            'assertStatus' => 200,
            'expectedResult' => [
                0 => [
                    'id' => 1,
                    'name' => 'Name1 Surname1',
                    'group' => [],
                    'courses' => [
                        '0' => [
                            'id' => 1,
                            'name' => 'math',
                        ],
                    ]
                ],
                1 => [
                    'id' => 2,
                    'name' => 'Name2 Surname2',
                    'group' => [
                        'id' => 1,
                        'name' => 'RR-01',
                    ],
                    'courses' => [],
                ],
                2 => [
                    'id' => 3,
                    'name' => 'Name3 Surname3',
                    'group' => [
                        'id' => 1,
                        'name' => 'RR-01',
                    ],
                    'courses' => [],
                ],

            ]
        ];
        yield 'one' => [
            'uri' => $baseRoute.'/1',
            'assertStatus' => 200,
            'expectedResult' => [
                'id' => 1,
                'name' => 'Name1 Surname1',
                'group' => [],
                'courses' => [
                    '0' => [
                        'id' => 1,
                        'name' => 'math',
                    ]
                ]
            ]
        ];
    }

    #[DataProvider('providerStudentsAdd')]
    public function testStudentsAdd(string $uri, array $params, int $assertStatus, array $expectedErrors): void
    {
        $response = $this->post($uri, $params);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);

        if ($assertStatus === 201) {
            $id = $content['studentId'];
            $this->assertIsInt($id);
            $newStudent = Student::find($id);
            $this->assertInstanceOf(Student::class, $newStudent);
        } else {
            $this->assertSame($expectedErrors, $content);
        }
    }

    public static function providerStudentsAdd(): \Generator
    {
        $baseUri = '/api/v1/students';
        yield 'add' => [
            'uri' => $baseUri,
            'params' => ['firstName' => 'Added', 'lastName' => 'User', 'groupId' => 1],
            'assertStatus' => 201,
            'expectedErrors' => [],
        ];
        yield 'noParams' => [
            'uri' => $baseUri,
            'params' => [],
            'assertStatus' => 422,
            'expectedErrors' => [
                'errors' => [
                    'firstName' => ['The first name field is required.'],
                    'lastName' => ['The last name field is required.'],
                    'groupId' => ['The group id field is required.'],
                ],
            ]
        ];
    }

    #[DataProvider('providerStudentsDelete')]
    public function testStudentsDelete(int $id, string $uri, int $assertStatus, ?array $expected): void
    {
        $response = $this->delete($uri);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);

        $this->assertEquals($expected, $content);

        if ($assertStatus === 204) {
            $student = Student::find($id);
            $this->assertSame(null, $student);
        }
    }

    public static function providerStudentsDelete(): \Generator
    {
        $baseUri = "/api/v1/students/";
        yield 'success' => [
            'id' => 3,
            'uri' => $baseUri . 3,
            'assertStatus' => 204,
            'expected' => null,
        ];
        yield 'alreadyDeleted' => [
            'id' => 0,
            'uri' => $baseUri . '299',
            'assertStatus' => 422,
            'expected' => ['errors' => 'Student already deleted.'],
        ];
    }

    #[DataProvider('providerStudentsRemoveGroup')]
    public function testStudentsRemoveGroup(int $id, string $uri, int $assertStatus, ?array $expected): void
    {
        $response = $this->delete($uri);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);

        $this->assertSame($expected, $content);

        if ($assertStatus === 204) {
            $this->assertEquals(null, Student::find($id)->group);
        }
    }

    public static function providerStudentsRemoveGroup(): \Generator
    {
        $baseUri = "/api/v1/students/{id}/remove-group";
        yield 'success' => [
            'id' => 1,
            'uri' => '/api/v1/students/1/remove-group',
            'assertStatus' => 204,
            'expected' => null,
        ];
        yield 'noStudent' => [
            'id' => 0,
            'uri' => '/api/v1/students/299/remove-group',
            'assertStatus' => 422,
            'expected' => [
                'errors' => [
                    'id' => ['The selected id is invalid.'],
                ],
            ],
        ];
    }
}
