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
        Schema::create('asset_types', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('structure');
            $table->timestamps();
            $table->foreignId('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->softDeletes();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary();
            $table->foreignUlid('asset_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->json('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_types');
        Schema::dropIfExists('assets');
    }
};
