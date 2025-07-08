<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->string('headline');          // "Hi, I'm Samir..."
            $table->string('full_name');         // "Samir Aoulad Amar"
            $table->string('location');          // "Tanger, Morocco"
            $table->text('bio');                 // "I'm a passionate full-stack developer..."
            $table->string('cv_url')->nullable(); // Path to CV file
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homes');
    }
};
