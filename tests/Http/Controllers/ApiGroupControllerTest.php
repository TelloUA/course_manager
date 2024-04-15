<?php

namespace Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Database\Seeders\TestApiGroupSeeder;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ApiGroupControllerTest extends TestCase
{
    public function setUp(): void
    {
        $this->seeder = TestApiGroupSeeder::class;
        parent::setUp();
    }

    #[DataProvider('providerGroupPages')]
    public function testGroupPages(string $uri, int $assertStatus, array $expectedResult): void
    {
        $response = $this->get($uri);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);
        $this->assertSame($expectedResult, $content['data']);
    }

    public static function providerGroupPages(): \Generator
    {
        $baseUri = '/api/v1/groups';
        yield 'list' => [
            'uri' => $baseUri,
            'assertStatus' => 200,
            'expectedResult' => [
                [
                    'id' => 1,
                    'name' => 'KO-01',
                    'count' => 2,
                ],
                [
                    'id' => 2,
                    'name' => 'RR-02',
                    'count' => 0,
                ],
                [
                    'id' => 3,
                    'name' => 'EE-03',
                    'count' => 0,
                ],
            ],
        ];
        yield 'one' => [
            'uri' => $baseUri . '/1',
            'assertStatus' => 200,
            'expectedResult' => [
                'id' => 1,
                'name' => 'KO-01',
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

    #[DataProvider('providerGroupAddStudent')]
    public function testGroupAddStudent(string $uri, array $params, int $assertStatus, array $expected): void
    {
        $response = $this->post($uri, $params);
        $response->assertStatus($assertStatus);
        $content = json_decode($response->getContent() ?: '', true);

        if ($assertStatus === 204) {
            $student = Student::find($expected['studentId']);
            $this->assertSame($expected['groupId'], $student->group->id);
            $group = Group::find($expected['groupId']);
            $this->assertSame(1, $group->students->count());
        } else {
            $this->assertSame($expected, $content);
        }
    }

    public static function providerGroupAddStudent(): \Generator
    {
        $baseUri = '/api/v1/groups';

        yield 'success' => [
            'uri' => $baseUri . '/3/add-student',
            'params' => ['studentId' => '4'],
            'assertStatus' => 204,
            'expected' => [
                'groupId' => 3,
                'studentId' => 4,
            ],
        ];
        yield 'noGroup' => [
            'uri' => $baseUri . '/299/add-student',
            'params' => ['studentId' => '3'],
            'assertStatus' => 422,
            'expected' => ['errors' => 'No such group'],
        ];
        yield 'noStudent' => [
            'uri' => $baseUri . '/3/add-student',
            'params' => ['studentId' => '299'],
            'assertStatus' => 422,
            'expected' => [
                'errors' => [
                    'studentId' => ['The selected student id is invalid.'],
                ]
            ],
        ];
    }
}
