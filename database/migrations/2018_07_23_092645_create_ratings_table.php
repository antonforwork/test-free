<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('ip', 15);
            $table->unsignedInteger('country_id')->nullable();
            $table->date('check_in');
            $table->unsignedInteger('rating');
            $table->timestamps();
            $table->foreign('country_id', 'country_relation')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('user_id', 'user_relation')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
