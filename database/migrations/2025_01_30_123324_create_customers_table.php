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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['individual', 'company'])->default('individual');
            $table->string('name');
            $table->string('surname');
            $table->foreignId('company_id')->constrained('companies')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('city_id')->constrained('cities')->nullable();
            $table->foreignId('district_id')->constrained('districts')->nullable();
            $table->foreignId('neighbourhood_id')->constrained('neighbourhoods')->nullable();
            $table->string('category')->default('MAL SAHİBİ');
            $table->boolean('status')->default(true);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
