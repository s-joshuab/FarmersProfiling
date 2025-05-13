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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('brgy_code');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('phone_number');
                $table->string('status');
                $table->string('user_type');
                $table->unsignedBigInteger('barangays_id');
                $table->unsignedBigInteger('municipalities_id');
                $table->unsignedBigInteger('provinces_id');

                $table->foreign('provinces_id')->references('id')->on('provinces');
                $table->foreign('municipalities_id')->references('id')->on('municipalities');
                $table->foreign('barangays_id')->references('id')->on('barangays');
                $table->rememberToken();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
