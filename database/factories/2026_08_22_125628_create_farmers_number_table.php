<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmersnumber', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangays_id');
            $table->unsignedBigInteger('farmersprofile_id');
            $table->string('farmersnumber');

            $table->foreign('barangays_id')->references('id')->on('barangays')->onDelete('cascade');
            $table->foreign('farmersprofile_id')->references('id')->on('farmersprofile')->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('farmersnumber');
    }
};
