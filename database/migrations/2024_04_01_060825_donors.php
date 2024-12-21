<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Donors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('donor_name');
            $table->enum('gender',['male', 'female', 'other'])->nullable()->default(null);
            $table->date('dob')->nullable();
            $table->string('blood_group');
            $table->string('mobile');
            $table->string('email');
            $table->string('state');
            $table->string('district');
            $table->string('city');
            $table->date('late_donation_date')->nullable();
            $table->integer('total_donation_unit')->default(0);
            $table->tinyInteger('has_donated_previously')->default(0);
            $table->string('last_six_months_procedures')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfeExists('donors');
    }
}
