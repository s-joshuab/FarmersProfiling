<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('imageUpload', function (Blueprint $table) {
            $table->id();
            $table->binary('img_desc')->nullable();
            $table->integer('img_size');
            $table->string('img_name');
            $table->foreignId('user_id')->constrained('users'); // Assuming 'users' is your users table name
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imageUpload');
    }
};
