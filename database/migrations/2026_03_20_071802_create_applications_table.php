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
        Schema::create('applications', function (Blueprint $table) {
            $table->id(); //id

            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete(); //id gia sư
            $table->foreignId('class_request_id')->constrained()->cascadeOnDelete(); //id đơn đăng lớp

            $table->string('message')->nullable(); //Lời nhắn
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); //Trạng thái

            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};