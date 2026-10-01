<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabuľka "product_types" – presný TYP produktu.
 *
 * Napr. "Nikotínové vrecká", "Elektronické cigarety", "Tabak", "Cigarety".
 * Každý produkt patrí práve do jedného typu.
 *
 * Vzťah: ProductType hasMany Product. V tabuľke products je odkaz cez
 * NOT NULL stĺpec product_type_id (typ je povinný).
 *
 * Pozor na rozdiel oproti "categories":
 *  - product_types = pevné zaradenie podľa druhu tovaru (1 na produkt)
 *  - categories    = marketingové prierezové štítky (viac na produkt)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // zobrazovaný názov typu
            $table->string('slug')->unique();  // URL-friendly identifikátor (napr. "nikotinove-vrecka"), jedinečný
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
