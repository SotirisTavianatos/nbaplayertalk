<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('team_id');
            $table->unsignedBigInteger('player_id');
            $table->year('from');//added this so we know the roster of any year
            $table->year('until')->nullable();//added this so we know the roster of any year
            $table->timestamps();

            $table->index('player_id');
            $table->foreign('player_id')->
            references('id')->on('players')
            ->onDelete('cascade');

            $table->index('team_id');
            $table->foreign('team_id')->
            references('id')->on('teams')
            ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_team');
    }
};
