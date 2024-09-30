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
        Schema::create('spaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('about');
            $table->foreignId('image_id')->nullable()->constrained('medias')->onDelete('set null');
            $table->enum('type', ['public', 'private']);
            $table->timestamps();
        });
        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('space_id')->constrained('spaces')->onDelete('cascade');
            $table->foreignId('inviter_id')->constrained('users')->onDelete('cascade');
            $table->string('token');
            $table->timestamps();
        });
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('u_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['member', 'star member', 'staff', 'owner']);
            $table->foreignId('space_id')->constrained('spaces')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('space_id')->constrained('spaces')->onDelete('cascade');
            $table->longText('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spaces');
        Schema::dropIfExists('invites');
        Schema::dropIfExists('memberships');
    }
};
