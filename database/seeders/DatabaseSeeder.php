<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ۱. ابتدا ۱۵ کارفرما می‌سازیم که هر کدام به صورت خودکار یک کاربر هم دارند
        $employers = \App\Models\Employer::factory(15)->create();

        // ۲. برای هر کارفرما بین ۱ تا ۳ شغل ایجاد می‌کنیم
        $employers->each(function ($employer) {
            \App\Models\Job::factory(rand(1, 3))->create([
                'employer_id' => $employer->employer_id,
            ]);
        });

        // ۳. حالا ۲۰ کارجو می‌سازیم که هر کدام ۲ درخواست کار برای شغل‌های تصادفی ثبت کنند
        $jobs = \App\Models\Job::all();

        \App\Models\Candidate::factory(20)
            ->create()
            ->each(function ($candidate) use ($jobs) {
                // برای هر کارجو ۲ درخواست کار به صورت تصادفی برای شغل‌ها ثبت می‌شود
                \App\Models\Application::factory(2)->create([
                    'candidate_id' => $candidate->candidate_id,
                    'job_id' => $jobs->random()->job_id,
                ]);
            });
    }
}
