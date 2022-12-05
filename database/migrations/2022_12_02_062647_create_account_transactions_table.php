<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->date('transaction_date');
            $table->text('description');
            $table->bigInteger('debit_account_id')->unsigned();
            $table->foreign('debit_account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('credit_account_id')->unsigned();
            $table->foreign('credit_account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('bank_transaction_id');
            $table->integer('bank_statement_id');
            $table->integer('transaction_amount');
            $table->string('status')->nullable();
            $table->integer('is_bank');
            $table->integer('bank_account_id');
            $table->string('type');
            $table->string('initiated_by');
            $table->string('form')->nullable();
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
        Schema::dropIfExists('account_transactions');
    }
}
