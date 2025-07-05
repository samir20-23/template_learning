<?php

// database/migrations/2025_05_26_000000_create_validations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidationsTable extends Migration
{
    public function up()
    {
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('validated_by');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('commentaire')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('validations');
    }
}
