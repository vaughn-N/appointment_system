<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('patient_id')->unsigned()->nullable()->index();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('gender')->nullable();

            $table->string('status')->nullable();

            $table->string('chief_complaint')->nullable();

            $table->string('contact_no')->nullable();

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
        Schema::dropIfExists('schedules');
    }
};
