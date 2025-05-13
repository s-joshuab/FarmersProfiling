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
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commodities_id');
            $table->unsignedBigInteger('farmersprofile_id');
            $table->string('farm_size');
            $table->string('farm_location');

            $table->foreign('farmersprofile_id')->references('id')->on('farmersprofile')->onDelete('cascade');
            $table->foreign('commodities_id')->references('id')->on('commodities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
