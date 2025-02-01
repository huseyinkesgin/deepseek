<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('area');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('neighbourhood_id')->constrained('neighbourhoods');
            $table->integer('land');
            $table->integer('parcel');
            $table->string('zooning_status');
            $table->string('similar');
            $table->string('size');
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
