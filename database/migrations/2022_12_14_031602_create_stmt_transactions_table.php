<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmtTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stmt_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('bank_statement_id')->unsigned();
            $table->foreign('bank_statement_id')->references('id')->on('bank_statements')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sr_no');
            $table->date('transaction_date');
            $table->date('value_date');
            $table->text('description');
            $table->string('ref_no');
            $table->string('cust_ref_no');
            $table->integer('transaction_amnt');
            $table->string('check_no');
            $table->string('status')->nullable();
            $table->string('type');
            $table->integer('running_balance');
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
        Schema::dropIfExists('stmt_transactions');
    }
}
