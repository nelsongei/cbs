<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('disbursement_option_id')->unsigned();
            $table->foreign('disbursement_option_id')->references('id')->on('disbursment_options')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('loan_product_id')->unsigned();
            $table->foreign('loan_product_id')->references('id')->on('loan_products')->onUpdate('cascade')->onDelete('cascade');
            $table->string('application_date');
            $table->boolean('is_new_application')->default(false);
            $table->boolean('is_disbursed')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->integer('amount_applied');
            $table->integer('amount_overpaid')->default(0);
            $table->float('interest_rate');
            $table->integer('period');
            $table->float('top_up_amount')->default(0.0);
            $table->string('account_number');
            $table->string('loan_status');
            $table->string('rate_type');
            $table->string('frequency');
            $table->string('repayment_start_date');
            $table->string('repayment_duration');
            //$table->boolean('is_disbursed')->default(false);
            $table->date('date_disbursed')->nullable();
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
        Schema::dropIfExists('loan_applications');
    }
}
