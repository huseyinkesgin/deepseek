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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code',25)->unique();
            $table->string('name',100);
            $table->string('tax_name',150)->nullable();
            $table->string('tax_number',10)->nullable();
            $table->string('tax_office',100)->nullable();
            $table->string('phone',16)->nullable();
            $table->string('email',100)->nullable();
            $table->string('address',200)->nullable();
            $table->foreignId('city_id')->constrained('cities')->nullable();
            $table->foreignId('district_id')->constrained('districts')->nullable();
            $table->foreignId('neighbourhood_id')->constrained('neighbourhoods')->nullable();
            $table->string('mersis_no',30)->nullable();
            $table->string('kep_address',45)->nullable();
            $table->string('iban',36)->nullable();
            $table->string('bank_name',100)->nullable();
            $table->string('bank_account_no',36)->nullable();
            $table->boolean('status')->default(true);
            $table->text('description',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
