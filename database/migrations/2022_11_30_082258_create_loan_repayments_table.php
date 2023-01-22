<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('loan_application_id')->unsigned();
            $table->foreign('loan_application_id')->references('id')->on('loan_applications')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->float('principal_paid')->default(0.0);
            $table->float('interest_paid')->default(0.0);
            $table->string('loan_transaction_id')->nullable();
            $table->string('default_period')->nullable();
            $table->string('bank_repdetails')->nullable();
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
        Schema::dropIfExists('loan_repayments');
    }
}
