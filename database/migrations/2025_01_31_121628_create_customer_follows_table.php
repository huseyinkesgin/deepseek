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
        Schema::create('customer_follows', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('service_type')->comment('1:TELEFON,2:SUNUM,3:YER GÖSTERME,4:KONTRAT, 5:DİĞER');
            $table->foreignId('portfolio_id')->constrained('portfolios');
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_follows');
    }
};
