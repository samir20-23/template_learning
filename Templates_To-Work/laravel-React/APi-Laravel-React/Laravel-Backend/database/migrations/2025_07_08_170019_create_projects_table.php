<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('url')->nullable();        // live/demo URL
            $table->string('repo_url')->nullable();   // source code repo
            $table->string('image_path')->nullable(); // e.g. 'projects/portfolio.png'
            $table->string('tech_stack')->nullable(); // comma-separated
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
