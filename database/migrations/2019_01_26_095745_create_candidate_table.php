<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name',50);
            $table->string('course',15);
            
            //Foreign Key Constraints
            $table->unsignedInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');

            $table->unsignedInteger('party_id');
            $table->foreign('party_id')->references('id')->on('partylist')->onDelete('cascade');

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
        Schema::dropIfExists('candidates');
    }
}
