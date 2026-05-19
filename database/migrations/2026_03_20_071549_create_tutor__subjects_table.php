<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tutor_subjects', function (Blueprint $table) {
            $table->id(); //id
            
            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete(); //id gia sư
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete(); //id môn học
            
            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor__subjects');
    }
};