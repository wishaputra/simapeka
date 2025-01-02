<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsnCourseProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asn_course_progress', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nip'); // Student ID (foreign key to users.nip)
            $table->unsignedBigInteger('course_id'); // Foreign key to courses.id
            $table->json('lesson_progress')->nullable(); // JSON to store completed lesson IDs
            $table->json('quiz_progress')->nullable(); // JSON to store completed quiz IDs
            $table->unsignedBigInteger('exam_id')->nullable(); // Final exam ID
            $table->boolean('is_final_exam_passed')->default(false); // Whether the student passed the exam
            $table->timestamp('completed_at')->nullable(); // Completion date of the course
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints (optional)
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asn_course_progress');
    }
}

