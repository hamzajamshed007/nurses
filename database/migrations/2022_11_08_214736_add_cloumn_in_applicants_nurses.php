<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCloumnInApplicantsNurses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants_nurses', function (Blueprint $table) {
            $table->dateTime('start_date')->after('job_id')->nullable();
            $table->dateTime('end_date')->after('start_date')->nullable();
            $table->time('start_time')->after('end_date')->nullable();
            $table->time('end_time')->after('start_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants_nurses', function (Blueprint $table) {
            //
        });
    }
}
