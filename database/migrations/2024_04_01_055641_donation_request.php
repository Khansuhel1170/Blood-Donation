<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors');
            $table->string('donor_name');
            $table->string('mobile');
            $table->string('email');
            $table->string('state');
            $table->string('city');
            $table->string('blood_group');
            $table->text('medical_condition')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfeExists('donation_request');
    }
}
