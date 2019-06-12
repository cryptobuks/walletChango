<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name');
            $table->string('project_description');
            $table->string('project_details');
            $table->string('image_url')->nullable();
            $table->integer('target_group_number');
            $table->integer('members_subscribed')->nullable()->default(0);
            $table->integer('project_target_amount')->nullable();
            $table->integer('project_initiated_by');
            $table->integer('group_id');
            $table->integer('status')->nullable();
            $table->integer('project_type')->default(0);
            $table->softDeletes();
            $table->float('amount_collected')->nullable()->default(0);
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
        Schema::dropIfExists('tbl_projects');
    }
}
