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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('code')->nullable();

            $table->integer('user_id')->unsigned()->nullable()->index();
            
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();


            $table->string('contact_no')->nullable();

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
        Schema::dropIfExists('patients');
    }
};
