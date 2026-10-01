<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pivot tabuľka "product_category" – prepája produkty s marketingovými kategóriami (M:N).
 *
 * Každý riadok = "tento produkt patrí do tejto kategórie" (napr. Akcia, Novinky).
 * Používa ju vzťah Product::categories() a Category::products().
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->id();

            // Pri zmazaní produktu alebo kategórie sa zmažú aj príslušné väzby (cascade).
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->timestamps();

            // Tá istá dvojica produkt–kategória sa nesmie objaviť dvakrát.
            $table->unique(['product_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category');
    }
};
