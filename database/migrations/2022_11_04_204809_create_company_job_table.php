<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_job', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->longText('description');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->longText('address');
            $table->float('lat');
            $table->float('long');
            $table->string('status');
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
        Schema::dropIfExists('company_job');
    }
}
