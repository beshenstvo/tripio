<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showplaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_card_id')->constrained('city_card')->onDelete('cascade');
            $table->enum('type', ['arch', 'temple', 'museum', 'nature']);
            $table->string('name', 255);
            $table->text('description');
            $table->text('photo');
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
        Schema::dropIfExists('showplaces');
    }
}
