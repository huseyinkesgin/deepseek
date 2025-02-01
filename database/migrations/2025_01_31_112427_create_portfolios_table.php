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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('portfolio_no');
            $table->string('real_estate_no');
            $table->string('status')->comment('1:KİRALIK,2:SATILIK');
            $table->string('portfolio_type')->comment('1:LAND,2:BUSINESS,3:HOUSING');
            $table->foreignId('land_id')->constrained('lands')->nullable();
            $table->foreignId('business_id')->constrained('businesses')->nullable();
            $table->foreignId('housing_id')->constrained('housings')->nullable();
            $table->string('portfolio_status')->comment('1:AKTİF,2:BEKLEMEDE,3:KONTRAT BEKLİYOR,4:TAMAMLANDI,5:İPTAL');
            $table->boolean('is_advert')->default(false);
            $table->foreignId('personnel_id')->constrained('personnels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
