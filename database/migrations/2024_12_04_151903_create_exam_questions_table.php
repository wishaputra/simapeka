<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id'); // Foreign key to exams table
            $table->string('question_text');
            $table->enum('type', ['essay', 'multiple_choice', 'true_false']);
            $table->json('options')->nullable(); // Options for multiple choice questions
            $table->string('correct_answer')->nullable();
            $table->integer('points');
            $table->timestamps();
        
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
