<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabuľka "brands" – výrobcovia / značky produktov (napr. VELO, IQOS, Marlboro).
 *
 * Vzťah: Brand hasMany Product (jedna značka má viacero produktov).
 * V tabuľke products je na ňu odkaz cez nullable stĺpec brand_id
 * (produkt nemusí mať priradenú značku).
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // zobrazovaný názov značky
            $table->string('slug')->unique();  // URL-friendly identifikátor (napr. "velo"), jedinečný
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
