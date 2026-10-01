<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabuľka "categories" – marketingové / prierezové kategórie.
 *
 * Napr. "Akcia", "Novinky", "Výpredaj". Produkt ich môže mať priradených viacero naraz.
 *
 * Vzťah: Category belongsToMany Product cez pivot tabuľku "product_category" (M:N).
 *
 * Pozor na rozdiel oproti "product_types":
 *  - categories    = voľné marketingové štítky (viac na produkt)
 *  - product_types = pevné zaradenie podľa druhu tovaru (1 na produkt)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // zobrazovaný názov kategórie
            $table->string('slug')->unique();  // URL-friendly identifikátor (napr. "akcia"), jedinečný
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
