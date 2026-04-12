<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administration_year', function (Blueprint $table) {
            $table->id();
        $table->string('year1'); // e.g., 2024
        $table->string('year2'); // e.g., 2025
        $table->foreignId('updated_by')->constrained('users');
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
        Schema::dropIfExists('administration_year');
    }
};