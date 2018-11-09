<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegesModulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('privileges_moduls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('prefix');
            // $table->string('fa_icon', 50);
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
         Schema::dropIfExists('privileges_moduls');
     }
}
