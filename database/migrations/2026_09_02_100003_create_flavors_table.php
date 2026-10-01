<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabuľka "flavors" – príchute (napr. Mint, Mango, Cola, Tobacco).
 *
 * Vzťah: Flavor belongsToMany Product cez pivot tabuľku "product_flavor".
 * Jeden produkt môže mať viac príchutí a jedna príchuť sa viaže na viacero produktov
 * (M:N vzťah).
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flavors', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // názov príchute
            $table->string('slug')->unique();  // URL-friendly identifikátor (napr. "mint"), jedinečný
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flavors');
    }
};
