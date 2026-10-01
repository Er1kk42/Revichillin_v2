// ============================================================================
// KONFIGURÁCIA VITE
// ----------------------------------------------------------------------------
// Vite je "build nástroj" pre frontend. Má dve úlohy:
//
//  1) Počas vývoja (npm run dev) spustí DEV SERVER na porte 5173.
//     Prehliadač si od neho pýta CSS a JS súbory. Vite ich spracuje
//     "za behu" (napr. Tailwind z tried vygeneruje CSS) a pri zmene súboru
//     stránku automaticky obnoví (tzv. HMR = Hot Module Replacement).
//
//  2) Pred nasadením (npm run build) všetko zbalí, zminifikuje a uloží
//     do public/build. Laravel potom načítava už hotové súbory
//     a dev server nie je potrebný.
//
// Laravel sa s Vite prepája cez direktívu @vite([...]) v Blade šablóne
// (resources/views/layouts/app.blade.php).
// ============================================================================

// defineConfig - pomocná funkcia, ktorá len "obalí" konfiguráciu.
// Nič nemení, ale editor (PhpStorm) vďaka nej vie napovedať dostupné možnosti.
import { defineConfig } from 'vite';

// Oficiálny plugin, ktorý prepája Vite s Laravelom
// (vytvára súbor public/hot, manifest pre produkciu, sleduje Blade súbory...)
import laravel from 'laravel-vite-plugin';

// Pomocník na stiahnutie fontov zo služby Bunny Fonts
// (alternatíva ku Google Fonts, ktorá je šetrnejšia k súkromiu - GDPR)
import { bunny } from 'laravel-vite-plugin/fonts';

// Plugin pre Tailwind CSS verzie 4 - vďaka nemu Vite rozumie
// Tailwind zápisom v CSS (@import 'tailwindcss', @apply, @theme, @source...)
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({

    // ------------------------------------------------------------------------
    // PLUGINY - rozšírenia, ktoré Vite pridávajú ďalšie schopnosti
    // ------------------------------------------------------------------------
    plugins: [
        laravel({
            // "Vstupné body" aplikácie - súbory, od ktorých Vite začína.
            // Všetko ostatné (napr. menu.css, navigation.js) sa k nim
            // pripája cez @import / import, takže ich sem netreba písať.
            input: ['resources/css/app.css', 'resources/js/app.js'],

            // Pri zmene Blade šablóny, routes a pod. sa stránka
            // v prehliadači automaticky obnoví
            refresh: true,

            // Font Instrument Sans - stiahnu sa len reálne používané hrúbky
            // (400 = normal, 500 = medium, 600 = semibold), aby stránka
            // nesťahovala zbytočné dáta
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),

        // Spracovanie Tailwind CSS
        tailwindcss(),
    ],

    // ------------------------------------------------------------------------
    // DEV SERVER - nastavenia platia iba pre "npm run dev"
    // ------------------------------------------------------------------------
    server: {
        // 0.0.0.0 = server počúva na všetkých sieťových rozhraniach.
        // Je to NUTNÉ, pretože Vite beží v Docker kontajneri
        // (služba "node" v docker-compose.yml). Keby počúval len na
        // "localhost", bol by dostupný iba vnútri kontajnera a prehliadač
        // na Windows by sa k nemu nedostal.
        host: '0.0.0.0',

        // Port, na ktorom server beží (v docker-compose.yml je namapovaný 5173:5173)
        port: 5173,

        // Ak je port 5173 obsadený, Vite skončí s chybou namiesto toho,
        // aby si potichu zvolil iný port (napr. 5174). Iný port by
        // nefungoval, lebo Docker mapuje iba 5173.
        strictPort: true,

        // HMR (automatické obnovenie stránky) komunikuje cez WebSocket.
        // Prehliadač sa musí pripojiť na "localhost", nie na vnútornú
        // IP adresu Docker kontajnera (napr. 172.18.0.3), ktorú Windows nepozná.
        hmr: {
            host: 'localhost',
        },

        // --------------------------------------------------------------------
        // SLEDOVANIE ZMIEN SÚBOROV
        // --------------------------------------------------------------------
        watch: {
            // PROBLÉM: Projekt je uložený na Windows a do Docker kontajnera
            // (Linux) je len "pripojený" (volume ./:/var/www). Linux sa
            // v takom prípade NEDOZVIE, že si súbor v PhpStorme zmenil
            // (neprídu mu systémové notifikácie - tzv. inotify udalosti).
            // Vite preto posielal staré CSS a zmeny v menu.css sa neprejavili.
            //
            // RIEŠENIE: polling = Vite sa sám každých 300 ms pozrie,
            // či sa súbory zmenili (porovná čas poslednej úpravy).
            usePolling: true,
            interval: 300,

            // Polling je ale "drahý" - každý súbor treba pravidelne kontrolovať.
            // Keď sa kontroloval aj priečinok vendor/ (~8 800 PHP súborov),
            // načítanie stránky trvalo až 80 sekúnd a kontajner vyťažoval CPU.
            // Preto vynecháme priečinky, v ktorých nie je nič pre frontend:
            ignored: [
                '**/vendor/**',       // PHP knižnice od Composera
                '**/node_modules/**', // JS knižnice od npm
                '**/storage/**',      // logy, cache, skompilované Blade šablóny
                '**/public/**',       // výstup buildu, obrázky, videá
                '**/.idea/**',        // nastavenia PhpStormu
                '**/database/**',     // migrácie a seedery
                '**/tests/**',        // testy
            ],
        },
    },
});
