<?php

namespace Database\Seeders;

class TestApiGroupSeeder extends AbstractTestSeeder
{
    public function run(): void
    {
        $this->groups = [
            ['name' => 'KO-01'],
            ['name' => 'RR-02'],
            ['name' => 'EE-03'],
        ];
        $this->students = [
            [
                'firstName' => 'Name1',
                'lastName' => 'Surname1',
                'groupId' => 1,
            ],
            [
                'firstName' => 'Name2',
                'lastName' => 'Surname2',
                'groupId' => 1,
            ],
            [
                'firstName' => 'Name3',
                'lastName' => 'Surname3',
                'groupId' => null,
            ],
            [
                'firstName' => 'Name4',
                'lastName' => 'Surname4',
                'groupId' => null,
            ],
        ];
        $this->setupModels();
    }
}
