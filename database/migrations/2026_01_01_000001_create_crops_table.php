<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // grains, fruits, vegetables, cash_crops
            $table->text('description');
            $table->string('soil_requirements')->nullable();
            $table->string('cultivation_method')->nullable();
            $table->string('harvest_time')->nullable();
            $table->text('nutritional_value')->nullable();
            $table->text('uses')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crops');
    }
};
