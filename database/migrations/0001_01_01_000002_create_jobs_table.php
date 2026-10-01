<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Základná migrácia Laravelu pre databázovú frontu úloh (QUEUE_CONNECTION=database).
 *
 * Vytvára tri tabuľky:
 *  - jobs         – čakajúce / práve spracovávané úlohy vo fronte
 *  - job_batches  – metadáta pre dávky úloh (Bus::batch())
 *  - failed_jobs  – úlohy, ktoré zlyhali aj po všetkých pokusoch (php artisan queue:retry / queue:failed)
 *
 * Spracováva ich worker: php artisan queue:work (v Dockeri cez "docker compose exec app php artisan queue:work").
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabuľka "jobs" – hlavná fronta. Každý riadok = jedna úloha čakajúca na spracovanie.
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();                                      // primárny kľúč
            $table->string('queue')->index();                 // názov fronty (napr. "default", "emails")
            $table->longText('payload');                       // serializovaná trieda úlohy + jej dáta
            $table->unsignedSmallInteger('attempts');          // počet doterajších pokusov o spracovanie
            $table->unsignedInteger('reserved_at')->nullable(); // kedy si úlohu "rezervoval" worker (null = voľná)
            $table->unsignedInteger('available_at');           // od kedy sa úloha smie spracovať (kvôli delay())
            $table->unsignedInteger('created_at');             // kedy bola úloha zaradená do fronty
        });

        // Tabuľka "job_batches" – sleduje priebeh dávok úloh (Bus::batch([...])->dispatch()).
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();                  // UUID dávky
            $table->string('name');                           // pomenovanie dávky
            $table->integer('total_jobs');                    // celkový počet úloh v dávke
            $table->integer('pending_jobs');                  // koľko ešte nebolo spracovaných
            $table->integer('failed_jobs');                   // koľko zlyhalo
            $table->longText('failed_job_ids');               // zoznam ID zlyhaných úloh
            $table->mediumText('options')->nullable();        // serializované nastavenia dávky (callbacky a pod.)
            $table->integer('cancelled_at')->nullable();      // timestamp zrušenia dávky (null = nezrušená)
            $table->integer('created_at');                    // vytvorenie dávky
            $table->integer('finished_at')->nullable();       // dokončenie dávky (null = beží)
        });

        // Tabuľka "failed_jobs" – archív úloh, ktoré definitívne zlyhali.
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();                                     // primárny kľúč
            $table->string('uuid')->unique();                // jedinečné UUID úlohy (na queue:retry)
            $table->string('connection');                     // ktoré queue spojenie úlohu spracovávalo
            $table->string('queue');                          // z ktorej fronty úloha pochádzala
            $table->longText('payload');                      // pôvodné serializované dáta úlohy
            $table->longText('exception');                    // text výnimky + stack trace dôvodu zlyhania
            $table->timestamp('failed_at')->useCurrent();     // kedy úloha zlyhala (default = teraz)

            $table->index(['connection', 'queue', 'failed_at']); // index na rýchle filtrovanie zlyhaní
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
