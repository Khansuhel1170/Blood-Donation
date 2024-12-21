<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BloodBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_banks', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('phone');
                $table->string('email')->unique();
                $table->text('address');
                $table->string('state');
                $table->string('district');
                $table->string('city');
                $table->enum('type',['public','private', 'hospital_based','independent'])->default('independent');
                $table->string('license_no');
                $table->string('blood_type_available');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfeExists('blood_banks');
    }
}
