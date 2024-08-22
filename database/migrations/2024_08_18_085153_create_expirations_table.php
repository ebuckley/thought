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
        // update the asset_types table to have an expiration_key field
        Schema::table('asset_types', function (Blueprint $table) {
            $table->string('expiration_key')
                ->nullable()
                ->comment('the key in the asset data which contains the expiration key if set then the asset type tracks expirations');
        });

        Schema::create('expirations', function (Blueprint $table) {
            $table->comment("
            An expiration is a way to manage assets that require some person to do a thing to them on a specific date. You should be emailed when they expire
            ");
            $table->id();
            $table->timestamps();
            $table->dateTime('triggerred_at')->nullable()
                ->comment('set if the expiration has been triggered');
            $table->datetime('invalidated_at')
                ->nullable()
                ->comment("if an expiration has this set, then it means that it is no longer needed and has been invalidated");
            $table->string("expiration_key")
                ->comment("the key in the asset data which contains the expiration key");

            // relates to an asset
            $table->foreignUlid('asset_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expirations');
        Schema::dropColumns('asset_types', ['expiration_key']);
    }
};
