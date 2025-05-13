<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrCodesTable extends Migration
{
    public function up()
    {
    Schema::create('qr_code', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('farmersprofile_id');
        $table->string('qr_code_data');


        $table->foreign('farmersprofile_id')->references('id')->on('farmersprofile')->onDelete('cascade');
        $table->timestamps();
    });
    }


    public function down()
    {
        Schema::dropIfExists('qr_code');
    }
}
