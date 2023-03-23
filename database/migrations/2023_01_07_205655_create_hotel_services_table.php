<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->boolean('car_parking');
            $table->boolean('baggae_room');
            $table->boolean('transfer');
            $table->boolean('smoking');
            $table->boolean('wi-fi');
            $table->boolean('wash_house');
            $table->boolean('air_сonditioning');
            $table->boolean('spa');
            $table->boolean('pool');
            $table->boolean('restaurant');
            $table->boolean('fitness');
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
        Schema::dropIfExists('hotel_services');
    }
}
