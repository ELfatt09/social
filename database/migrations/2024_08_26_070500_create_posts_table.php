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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('body')->nullable();
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->longText('body');
            $table->timestamps();
        });
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('cascade');
            $table->foreignId('pfp_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('file_type'); // e.g., 'image', 'video'
            $table->string('file_name'); // original file name
            $table->string('file_path'); // path to the uploaded file
            $table->string('mime_type'); // MIME type of the file (e.g., image/jpeg, video/mp4)
            $table->unsignedInteger('file_size'); // file size in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('medias');
    }
};
