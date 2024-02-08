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
        Schema::create('draws', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('lotteries_id');
          $table->foreign('lotteries_id')->references('id')->on('lotteries')->onDelete('cascade')->onUpdate('cascade');
          $table->timestamp('draw_date');
          $table->integer('won_number')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draws');
    }
};
