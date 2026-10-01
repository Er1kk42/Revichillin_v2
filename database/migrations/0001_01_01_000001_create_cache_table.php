<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Základná migrácia Laravelu pre databázový cache driver (CACHE_STORE=database).
 *
 * Vytvára dve tabuľky:
 *  - cache        – uložené položky cache (kľúč => hodnota + čas expirácie)
 *  - cache_locks  – atomické zámky (Cache::lock()), aby dva procesy nespracovali to isté naraz
 *
 * Ak sa používa Redis/Memcached, tieto tabuľky zostávajú prázdne.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabuľka "cache" – samotné cache záznamy.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();              // názov cache kľúča = primárny kľúč
            $table->mediumText('value');                   // serializovaná uložená hodnota
            $table->bigInteger('expiration')->index();     // unix timestamp, kedy záznam expiruje
        });

        // Tabuľka "cache_locks" – distribuované zámky pre Cache::lock() / atomic locks.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();              // názov zámku
            $table->string('owner');                       // identifikátor procesu, ktorý zámok drží
            $table->bigInteger('expiration')->index();     // timestamp automatického uvoľnenia zámku
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
