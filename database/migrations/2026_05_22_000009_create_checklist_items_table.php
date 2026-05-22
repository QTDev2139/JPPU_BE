<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained('checklists')->cascadeOnDelete();
            $table->string('content', 255);
            $table->boolean('is_completed')->default(false);
            $table->float('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};