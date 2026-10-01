<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabuľka "products" – samotné produkty e-shopu s nikotínovými produktmi.
 *
 * Vzťahy:
 *  - belongsTo Brand         (brand_id, nullable – produkt nemusí mať značku)
 *  - belongsTo ProductType   (product_type_id, povinný – každý produkt má práve jeden typ)
 *  - belongsToMany Flavor    (cez pivot "product_flavor")
 *  - belongsToMany Category  (cez pivot "product_category")
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                  // názov produktu
            $table->string('slug')->unique();                        // URL-friendly identifikátor, jedinečný
            $table->decimal('price', 8, 2);                          // cena (max 999 999.99)
            $table->text('description')->nullable();                 // popis produktu (voliteľný)
            $table->integer('stock')->default(0);                    // počet kusov na sklade
            $table->integer('nicotine_strength')->nullable();        // obsah nikotínu v mg (null = bez nikotínu / neuvedené, napr. tabak)

            // Značka – voliteľná. Pri zmazaní značky sa brand_id nastaví na NULL,
            // produkt zostane zachovaný.
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            // Typ produktu – povinný. Zmazať typ nejde, kým naň odkazuje nejaký produkt
            // (restrictOnDelete = default správanie).
            $table->foreignId('product_type_id')
                ->constrained('product_types')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
