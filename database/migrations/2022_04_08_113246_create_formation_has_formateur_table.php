<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationHasFormateurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formation_has_formateur', function (Blueprint $table) {
            $table
            ->bigInteger("formation_id")
            ->unsigned()
            ->nullable();
            $table
            ->bigInteger("formateur_id")
            ->unsigned()
            ->nullable();

            $table
                ->foreign("formation_id")
                ->references("id")
                ->on("formations")
                ->onDelete("cascade");
            $table
                ->foreign("formateur_id")
                ->references("id")
                ->on("formateurs");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formation_has_formateur');
    }
}
