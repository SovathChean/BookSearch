<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TfIdf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tf_idfs', function (Blueprint $table) {
            $table->id();
            $table->text('term');
            $table->bigInteger('doc');
            $table->unsignedInteger('type');
            $table->double('tf');
            $table->double('idf');
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
    }
}
