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
        Schema::create('codes_has_snippets', function (Blueprint $table) {
            $table->foreignId('code_id')
                ->constrained('codes')
                ->cascadeOnDelete();
            $table->foreignId('snippet_id')
                ->constrained('snippets')
                ->cascadeOnDelete();
            $table->primary(['code_id', 'snippet_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes_has_snippets');
    }
};
