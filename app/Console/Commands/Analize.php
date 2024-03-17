<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Analize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:analize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        for ($i = 0; $i < 10; $i++) {
            do {
                $string = strtoupper(Str::random(2));
            } while (!preg_match('/[A-Z]{2}/', $string));
            $number = rand(10, 99);
            $this->info($string . '-' . $number);
        }
    }
}
