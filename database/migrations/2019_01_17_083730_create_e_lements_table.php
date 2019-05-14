<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateELementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_lements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('furl')->nullable();
            $table->string('turl')->nullable();
            $table->string('gurl')->nullable();
            $table->integer('twidth');
            $table->integer('theight');
            $table->integer('mwidth');
            $table->integer('mheight');
            $table->integer('lwidth');
            $table->integer('lheight');
            $table->integer('bwidth');
            $table->integer('bheight');
            $table->string('email');
            $table->longText('map')->nullable();
            
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
        Schema::dropIfExists('e_lements');
    }
}
