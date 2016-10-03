<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user_id');
            $table->string('message');
            $table->boolean('read')->default(false);
            $table->boolean('fixed')->default(false);
            $table->string('fixed_by');
            $table->boolean('reason_fixed')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bugs');
    }
}
