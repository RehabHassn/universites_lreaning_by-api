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
        Schema::create('collages_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collage_id')->constrained('collages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('year_id')->constrained('years')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create__collages_years');
    }
};
