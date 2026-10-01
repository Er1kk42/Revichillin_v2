<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Základná migrácia Laravelu pre autentifikáciu používateľov.
 *
 * Vytvára tri tabuľky:
 *  - users                  – účty používateľov (prihlasovanie, registrácia)
 *  - password_reset_tokens  – dočasné tokeny na obnovu zabudnutého hesla
 *  - sessions               – serverové session záznamy (keď SESSION_DRIVER=database)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabuľka "users" – hlavná tabuľka s účtami používateľov.
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                   // primárny kľúč (auto-increment)
            $table->string('name');                         // meno používateľa
            $table->string('email')->unique();              // e-mail, musí byť jedinečný (slúži na prihlásenie)
            $table->timestamp('email_verified_at')->nullable(); // kedy bol e-mail overený (null = neoverený)
            $table->string('password');                     // zahashované heslo (bcrypt/argon)
            $table->rememberToken();                         // token pre funkciu "zapamätať si ma"
            $table->timestamps();                            // created_at / updated_at
        });

        // Tabuľka "password_reset_tokens" – tokeny pre e-mailový odkaz na reset hesla.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();             // e-mail používateľa = primárny kľúč (1 aktívny token na e-mail)
            $table->string('token');                        // zahashovaný reset token
            $table->timestamp('created_at')->nullable();    // čas vytvorenia – podľa neho sa token po čase zneplatní
        });

        // Tabuľka "sessions" – ukladá session dáta v DB namiesto súborov (SESSION_DRIVER=database).
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();               // ID session (z cookie)
            $table->foreignId('user_id')->nullable()->index(); // ktorý používateľ patrí k session (null = neprihlásený)
            $table->string('ip_address', 45)->nullable();  // IP adresa klienta (45 znakov kvôli IPv6)
            $table->text('user_agent')->nullable();        // prehliadač / zariadenie klienta
            $table->longText('payload');                    // serializované session dáta
            $table->integer('last_activity')->index();      // timestamp poslednej aktivity (na garbage collection starých session)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
