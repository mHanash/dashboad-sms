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
        Schema::create('list_campaign_phone', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_campaign_id')->constrained('list_campaigns');
            $table->foreignId('phone_id')->constrained('phones');
            $table->boolean('is_submit')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_campaign_phone');
    }
};
