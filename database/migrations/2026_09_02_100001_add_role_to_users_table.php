<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pridáva do tabuľky "users" stĺpec "role".
 *
 * Rozlišuje bežného zákazníka e-shopu ('customer') od administrátora ('admin'),
 * ktorý má prístup do administrácie. Nový používateľ je vždy 'customer'.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // enum = povolené sú len hodnoty 'customer' alebo 'admin', default 'customer'
            $table->enum('role', ['customer', 'admin'])
                ->default('customer')
                ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
