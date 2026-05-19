<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); //id

            $table->string('name'); //Tên người dùng
            $table->enum('gender', ['male', 'female'])->nullable(); //Giới tính
            $table->string('email')->unique(); //Email
            $table->string('phone')->nullable();
            $table->string('password'); //Mật khẩu
            $table->enum('role', ['student', 'tutor', 'admin', 'both'])->default('student'); //Trạng thái

            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};