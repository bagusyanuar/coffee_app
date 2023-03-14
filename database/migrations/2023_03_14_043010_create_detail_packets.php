<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPackets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packet_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('packet_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->integer('qty');
            $table->timestamps();
            $table->foreign('packet_id')->references('id')->on('packets');
            $table->foreign('barang_id')->references('id')->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packet_details');
    }
}
