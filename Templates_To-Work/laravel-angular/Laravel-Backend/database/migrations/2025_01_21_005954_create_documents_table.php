<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // file extension or document type
            $table->string('chemin_fichier'); // file path
            $table->string('original_name')->nullable(); // original filename
            $table->bigInteger('file_size')->nullable(); // file size in bytes
            $table->string('mime_type')->nullable(); // MIME type
            $table->text('description')->nullable(); // document description
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->boolean('is_public')->default(false); // public/private document
            $table->integer('download_count')->default(0); // track downloads
            $table->unsignedBigInteger('categorie_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['status', 'is_public']);
            $table->index(['categorie_id', 'status']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};