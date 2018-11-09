<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivilegesRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('privileges_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_create')->nullable();
            $table->boolean('is_read')->nullable();
            $table->boolean('is_edit')->nullable();
            $table->boolean('is_delete')->nullable();
            $table->integer('privilege_id');
            $table->integer('privilege_moduls_id');
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
         Schema::dropIfExists('privileges_permissions');
     }
}
