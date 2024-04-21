<?php

namespace Tests\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed --class=TestSeeder');
    }
    #[DataProvider('providerGroups')]
    public function testGroupPages(string $uri, int $assertStatus): void
    {
        $response = $this->get($uri);
        $response->assertStatus($assertStatus);
    }

    public static function providerGroups(): array
    {
        return [
            'groupsList' => [
                'uri' => '/groups',
                'assertStatus' => 200,
            ],
            'groupSingle' => [
                'uri' => '/group/1',
                'assertStatus' => 200,
            ],
        ];
    }

    public function testGroupAddStudent(): void
    {
        $studentId = 2;
        $groupId = 1;

        $response = $this->post('/group/'. $groupId . '/add-student', ['studentId' => $studentId]);
        $response->assertStatus(302);

        $student = Student::find($studentId);
        $this->assertSame($student->group_id, $groupId);
    }

    public function testGroupRemoveStudent(): void
    {
        $studentId = 1;
        $groupId = 1;

        $response = $this->delete('/group/' . $groupId . '/remove-student', ['studentId' => $studentId]);
        $response->assertStatus(302);

        $student = Student::find($studentId);
        $this->assertNull($student->group_id);
    }
}
