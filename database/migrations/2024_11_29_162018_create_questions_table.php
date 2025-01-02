<?php

// database/migrations/xxxx_xx_xx_create_questions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question_text'); // The quiz question
            $table->enum('type', ['multiple-choice', 'true-false', 'short-answer']); // Question type
            $table->json('options')->nullable(); // Options for multiple-choice questions
            $table->text('correct_answer'); // Correct answer(s)
            $table->integer('points'); // Points for the question
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}

