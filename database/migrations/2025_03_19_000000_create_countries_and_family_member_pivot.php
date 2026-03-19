<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('flag_path')->nullable();
            $table->timestamps();
        });

        Schema::create('country_family_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained('family_members')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['family_member_id', 'country_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_family_member');
        Schema::dropIfExists('countries');
    }
};
