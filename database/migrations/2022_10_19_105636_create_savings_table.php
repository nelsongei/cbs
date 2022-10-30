<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('saving_account_id')->unsigned();
            $table->foreign('saving_account_id')->references('id')->on('saving_accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->string("saving_amount");
            $table->string("management_fee")->nullable();
            $table->string("type");
            $table->string("date");
            $table->string("description")->nullable();
            $table->string("payment_method");
            $table->string("bank_sadetails")->nullable();
            $table->string("transacted_by")->nullable();
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
        Schema::dropIfExists('savings');
    }
}
