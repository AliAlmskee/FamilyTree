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
      Schema::create('family_members', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->enum('gender', ['male', 'female']);
        $table->string('address')->nullable(); 
        $table->boolean('is_alive');
        
        // Relationship IDs
        $table->foreignId('mother_id')->nullable()->constrained('family_members');
        $table->foreignId('father_id')->nullable()->constrained('family_members');
        $table->foreignId('spouse_id')->nullable()->constrained('family_members');
        
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
