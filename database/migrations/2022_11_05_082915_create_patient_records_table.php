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
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id();

            $table->integer('patient_id')->unsigned()->nullable()->index();
            
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();

            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('temperature')->nullable();

            $table->longText('symptoms')->nullable();

            $table->longText('complaint')->nullable();

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
        Schema::dropIfExists('patient_records');
    }
};
