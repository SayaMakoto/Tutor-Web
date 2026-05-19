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
        Schema::create('grades', function (Blueprint $table) {
            $table->id(); //id

            $table->string('name');   //Tiểu học, THCS, THPT, Cao đẳng, Đại học, Công nghệ thông tin,...
            $table->string('sort_order')->nullable(); // Sắp xếp hiển thị (1, 2, 3,...)
            $table->boolean('status')->default(1); // Trạng thái
            
            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};