<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained('lists')->cascadeOnDelete();
            $table->string('title', 255);
            $table->longText('description')->nullable();
            $table->float('position');
            $table->string('cover', 255)->nullable();
            $table->dateTime('due_date')->nullable();
            $table->boolean('due_complete')->default(false);
            $table->dateTime('reminder')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};