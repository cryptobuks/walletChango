<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamaasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_chamaa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("chamaa_name");
            $table->string("members_count")->nullable()->default(0);
            $table->string("chamaa_uuid");
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
        Schema::dropIfExists('tbl_chamaa');
    }
}
