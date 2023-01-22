<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->bigInteger('share_account_id')->unsigned();
            $table->foreign('share_account_id')->references('id')->on('share_accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('trans_no')->nullable();
            $table->string('type');
            $table->text('description');
            $table->integer('amount');
            $table->string('bank_sadetails');
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
        Schema::dropIfExists('share_transactions');
    }
}
