<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type');     // e.g. 'Email', 'Phone', 'LinkedIn'
            $table->string('value');    // e.g. 'you@example.com', '+212600000000'
            $table->string('icon')->nullable(); // optional icon name
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
