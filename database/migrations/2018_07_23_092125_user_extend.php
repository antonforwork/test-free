<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserExtend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $t) {
            $t->unsignedInteger('country_id')->nullable();
            $t->boolean('is_active');
            $t->foreign('country_id', 'country_id_relation')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function (Blueprint $t) {

            $t->dropForeign('country_id_relation');
            $t->dropColumn(['country_id', 'is_active']);
        });
    }
}
