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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('user_email');
            $table->string('user_name');
            $table->string('unique_id');
            $table->string('comments');
            $table->string('comments_vid_path');
            $table->string('comments_img_path');
            $table->string('comments_link');
            $table->date('date');
            $table->foreign('id')->references('id')->on('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
