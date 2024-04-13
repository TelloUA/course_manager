<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected ?string $seeder = null;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');

        if (!is_null($this->seeder) && class_exists($this->seeder)) {
            $command = 'db:seed ' . basename(str_replace('\\', '/', ($this->seeder)));
            Artisan::call($command);
        }
    }
}
