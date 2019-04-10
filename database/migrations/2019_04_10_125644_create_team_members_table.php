<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('team_id');
            $table->timestamps();
            // FK
            $table
             ->foreign('user_id')
             ->references('id')
             ->on('users')
             ->onDelete('cascade')
             ->onUpdate('cascade');
            // FK
            $table
             ->foreign('team_id')
             ->references('id')
             ->on('teams')
             ->onDelete('cascade')
             ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('team_members');
    }
}
