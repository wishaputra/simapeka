<?php

// database/migrations/xxxx_xx_xx_create_lessons_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['video', 'document', 'text']); // Lesson type (video, document, etc.)
            $table->text('content'); // Path or URL to the lesson content
            $table->integer('duration'); // Lesson duration in minutes
            $table->boolean('status')->default(false); // Published or draft
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}

