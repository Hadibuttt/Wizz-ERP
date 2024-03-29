<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_id')->nullable();
            $table->string('route_id')->nullable();
            $table->date('date')->nullable();
            $table->string('rate')->nullable();
            $table->string('status')->nullable()->default('In Queue');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('notify_start')->nullable()->default('0');
            $table->string('notify_complete')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
