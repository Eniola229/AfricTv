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
            $table->string('user_id');
            $table->string('user_name');
            $table->string('unique_id');
            $table->string('user_email');
            $table->string('post_title');
            $table->string('post_img_path');
            $table->string('post_vid_path');
            $table->string('post_pdf_path');
            $table->string('post_song_path');
            $table->string('category');
            $table->string('link');
            $table->string('post_intro');
            $table->string('post_body');
            $table->string('post_ending');
            $table->string('post_views');
            $table->date('date');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
