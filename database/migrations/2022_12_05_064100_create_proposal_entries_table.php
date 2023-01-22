<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_entries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('proposal_category_id')->unsigned();
            $table->foreign('proposal_category_id')->references('id')->on('proposal_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('year');
            $table->float('first_quarter');
            $table->float('second_quarter');
            $table->float('third_quarter');
            $table->float('fourth_quarter');
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
        Schema::dropIfExists('proposal_entries');
    }
}
