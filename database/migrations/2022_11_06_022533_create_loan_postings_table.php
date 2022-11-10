<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanPostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_postings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('loan_product_id')->unsigned();
            $table->foreign('loan_product_id')->references('id')->on('loan_products')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('debit_account_id')->unsigned();
            $table->foreign('debit_account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('credit_account_id')->unsigned();
            $table->foreign('credit_account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
//            $table->integer('debit_account_');
//            $table->integer('credit_account');
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
        Schema::dropIfExists('loan_postings');
    }
}
