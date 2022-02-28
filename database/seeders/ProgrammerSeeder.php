<?php

namespace Database\Seeders;

use App\Models\Programmer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProgrammerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        File::deleteDirectory(storage_path("app/public/programmers"));
        File::makeDirectory(storage_path("app/public/programmers"));
        Programmer::factory(20)->create();
    }
}
