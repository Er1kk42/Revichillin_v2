<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pivot tabuľka "product_flavor" – prepája produkty s príchuťami (M:N).
 *
 * Každý riadok = "tento produkt je dostupný v tejto príchuti".
 * Používa ju vzťah Product::flavors() a Flavor::products().
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_flavor', function (Blueprint $table) {
            $table->id();

            // Pri zmazaní produktu alebo príchute sa zmažú aj príslušné väzby (cascade).
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('flavor_id')->constrained('flavors')->cascadeOnDelete();

            $table->timestamps();

            // Tá istá dvojica produkt–príchuť sa nesmie objaviť dvakrát.
            $table->unique(['product_id', 'flavor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_flavor');
    }
};
