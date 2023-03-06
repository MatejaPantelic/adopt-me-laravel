<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned();
            $table->bigInteger('adopter_user_id')->unsigned();
            $table->bigInteger('animal_id')->unsigned();
            $table->enum('status', ['request_accepted','request_denied','request_sent']);
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('adopter_user_id')->references('id')->on('users');
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->softDeletes();

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
        Schema::dropIfExists('transfers');
    }
};
