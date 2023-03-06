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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->string('name');
            $table->string('breed');
            $table->enum('gender', ['male','female']);
            $table->enum('pedigree', ['yes','no']);
            $table->enum('status', ['adopting','giving_away','adopted','in_process']);
            $table->date('birth_date')->nullable();
            $table->string('color')->nullable();
            $table->float('weight')->nullable();
            $table->string('description')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
            $table->softDeletes();

            $table->index('gender');
            $table->index('status');
            $table->index('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
};
