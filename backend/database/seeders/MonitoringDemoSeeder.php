<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoringDemoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('sections')->insert([
            [
                'id' => 1,
                'course_id' => 1,
                'academic_year_id' => 1,
                'semester_id' => 1,
                'section_name' => 'BSIT-1A',
                'year_level' => 1,
                'adviser_id' => 1,
                'capacity' => 40,
                'status' => 'open',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('enrollments')->insert([
            [
                'id' => 1,
                'student_id' => 1,
                'section_id' => 1,
                'academic_year_id' => 1,
                'semester_id' => 1,
                'enrollment_date' => '2026-08-01',
                'status' => 'enrolled',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('enrollment_subjects')->insert([
            [
                'id' => 1,
                'enrollment_id' => 1,
                'subject_id' => 1,
                'professor_id' => 1,
                'subject_status' => 'enrolled',
                'final_grade' => null,
                'remarks' => 'In Progress',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'enrollment_id' => 1,
                'subject_id' => 2,
                'professor_id' => 1,
                'subject_status' => 'enrolled',
                'final_grade' => null,
                'remarks' => 'In Progress',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'enrollment_id' => 1,
                'subject_id' => 3,
                'professor_id' => 1,
                'subject_status' => 'enrolled',
                'final_grade' => null,
                'remarks' => 'In Progress',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('grades')->insert([
            // IT101 - moderate / declining
            [
                'enrollment_subject_id' => 1,
                'grading_period_id' => 1,
                'professor_id' => 1,
                'grade' => 82.00,
                'remarks' => 'In Progress',
                'status' => 'approved',
                'submitted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'enrollment_subject_id' => 1,
                'grading_period_id' => 2,
                'professor_id' => 1,
                'grade' => 76.00,
                'remarks' => 'In Progress',
                'status' => 'approved',
                'submitted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // IT102 - high risk of failing
            [
                'enrollment_subject_id' => 2,
                'grading_period_id' => 1,
                'professor_id' => 1,
                'grade' => 74.00,
                'remarks' => 'In Progress',
                'status' => 'approved',
                'submitted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'enrollment_subject_id' => 2,
                'grading_period_id' => 2,
                'professor_id' => 1,
                'grade' => 68.00,
                'remarks' => 'In Progress',
                'status' => 'approved',
                'submitted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // IT201 - stable
            [
                'enrollment_subject_id' => 3,
                'grading_period_id' => 1,
                'professor_id' => 1,
                'grade' => 88.00,
                'remarks' => 'In Progress',
                'status' => 'approved',
                'submitted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'enrollment_subject_id' => 3,
                'grading_period_id' => 2,
                'professor_id' => 1,
                'grade' => 90.00,
                'remarks' => 'In Progress',
                'status' => 'approved',
                'submitted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
