<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tutor_documents', function (Blueprint $table) {
            $table->id(); //id tài liệu

            $table->foreignId('tutor_id')->constrained()->onDelete('cascade'); //id gia sư

            $table->string('file_path'); // đường dẫn file
            $table->string('type')->nullable(); // bằng cấp, chứng chỉ, CMND...

            $table->timestamps(); //created_at và updated_at
            $table->softDeletes(); //deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_documents');
    }
};