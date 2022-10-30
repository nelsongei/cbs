<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('membership_no');
            $table->string('title');
            $table->string('id_no')->nullable();
            $table->string('photo')->default('https://icons.veryicon.com/png/o/miscellaneous/two-color-icon-library/user-286.png');
            $table->string('marital_status');
            $table->bigInteger('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('dob');
            $table->string('nationality');
            $table->string('gender');
            $table->string('is_active')->default(true);
            $table->timestamps();
            $table->index('organization_id');
            $table->index('branch_id');
            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
