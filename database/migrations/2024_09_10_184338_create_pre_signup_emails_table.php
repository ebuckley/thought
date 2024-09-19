<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pre_signup_emails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('last_emailed_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->string('email')->unique();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_super_user')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_signup_emails');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_super_user');
        });
    }
};