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

            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();

            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('patient_id')->unsigned()->nullable()->index();

            $table->string('date')->unsigned()->nullable()->index();
            $table->string('time_start')->unsigned()->nullable()->index();
            $table->string('time_end')->unsigned()->nullable()->index();
            
            $table->tinyInteger('deprecated')->default(0);

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
