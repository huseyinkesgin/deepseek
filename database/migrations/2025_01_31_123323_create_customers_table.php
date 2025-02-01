<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25)->unique();
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('phone', 16)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('address', 200)->nullable();
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('neighbourhood_id')->constrained('neighbourhoods');
            $table->foreignId('company_id')->constrained('companies');
            $table->string('identity_number', 11)->nullable();
            $table->string('tax_number', 10)->nullable();
            $table->string('tax_office', 100)->nullable();
            $table->boolean('status')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
