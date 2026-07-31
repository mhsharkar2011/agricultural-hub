<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pest_strategies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // monitoring, biological, organic, treatment
            $table->text('description');
            $table->text('methods')->nullable();
            $table->text('tips')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pest_strategies');
    }
};
