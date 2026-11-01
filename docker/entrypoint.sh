#!/bin/sh
# =============================================================================
# ENTRYPOINT KONTAJNERA "app"
# -----------------------------------------------------------------------------
# Docker tento skript spustí pri KAŽDOM štarte kontajnera, ešte pred php-fpm
# (nastavené v Dockerfile cez ENTRYPOINT). Vďaka nemu stačí na úplne čistom
# počítači spustiť jediný príkaz:
#
#     docker compose up -d --build
#
# a aplikácia sa sama pripraví: nainštaluje PHP balíčky, vytvorí .env,
# vytvorí tabuľky v databáze a PRI PRVOM SPUSTENÍ naplní DB ukážkovými dátami.
#
# Každý krok je "idempotentný" = keď ho spustíme opakovane, nič nepokazí.
# Napr. .env sa vytvorí len ak ešte neexistuje, seed beží len raz.
# =============================================================================

# set -e = ak niektorý príkaz zlyhá, skript okamžite skončí s chybou.
# Kontajner tak nespustí "polofunkčnú" aplikáciu a chybu uvidíme
# v "docker compose logs app".
set -e

# Pracujeme v koreňovom priečinku Laravelu (sem je namapovaný projekt).
cd /var/www


# -----------------------------------------------------------------------------
# 1. PHP ZÁVISLOSTI (priečinok vendor/)
# -----------------------------------------------------------------------------
# vendor/ nie je v gite (je v .gitignore), takže po naklonovaní repozitára
# chýba. Bez neho Laravel nefunguje vôbec. composer install stiahne presne
# tie verzie balíčkov, ktoré sú zapísané v composer.lock.
# Spúšťame ho len ak vendor/ ešte neexistuje, aby štart nebol zbytočne pomalý.
if [ ! -f vendor/autoload.php ]; then
    echo "[entrypoint] Inštalujem PHP závislosti (composer install)..."
    composer install --no-interaction --prefer-dist
fi


# -----------------------------------------------------------------------------
# 2. KONFIGURÁCIA (.env) A ŠIFROVACÍ KĽÚČ
# -----------------------------------------------------------------------------
# .env obsahuje nastavenia prostredia (pripojenie k DB, heslá...), preto
# nie je v gite. Ako šablónu použijeme .env.example, kde sú hodnoty
# nastavené pre Docker (DB_HOST=db = názov služby v docker-compose.yml).
if [ ! -f .env ]; then
    echo "[entrypoint] Vytváram .env z .env.example..."
    cp .env.example .env
fi

# APP_KEY je kľúč, ktorým Laravel šifruje session a cookies.
# V .env.example je prázdny, takže ho pri prvom spustení vygenerujeme.
# grep hľadá riadok "APP_KEY=" s nejakou hodnotou za "=".
if ! grep -q '^APP_KEY=.\+' .env; then
    echo "[entrypoint] Generujem APP_KEY..."
    php artisan key:generate --force
fi


# -----------------------------------------------------------------------------
# 3. PRÁVA NA ZÁPIS
# -----------------------------------------------------------------------------
# php-fpm obsluhuje požiadavky pod používateľom www-data. Ten musí vedieť
# zapisovať do:
#   - storage/          logy, session, cache, skompilované Blade šablóny
#   - bootstrap/cache/  cache konfigurácie a balíčkov
#   - public/img/products/  obrázky produktov nahrané cez Filament (upload)
# chgrp = skupina súborov bude www-data, chmod g+rwX = skupina môže čítať
# a zapisovať (X = spúšťať len priečinky). Vlastník súborov sa nemení,
# takže ich vieš ďalej upravovať aj ty mimo Dockeru.
mkdir -p public/img/products
chgrp -R www-data storage bootstrap/cache public/img/products
chmod -R g+rwX storage bootstrap/cache public/img/products


# -----------------------------------------------------------------------------
# 4. DATABÁZA: MIGRÁCIE + UKÁŽKOVÉ DÁTA PRI PRVOM SPUSTENÍ
# -----------------------------------------------------------------------------
# Na databázu čakať nemusíme: v docker-compose.yml má služba "app"
#     depends_on: db: condition: service_healthy
# takže Docker spustí tento kontajner až keď MySQL odpovedá (healthcheck).
#
# Ako zistíme, že ide o PRVÉ spustenie?
# Laravel si v tabuľke "migrations" pamätá, ktoré migrácie už spustil.
# Príkaz "migrate:status" skončí chybou, ak táto tabuľka ešte neexistuje
# = databáza je úplne prázdna = prvé spustenie.
if ! php artisan migrate:status > /dev/null 2>&1; then
    # Prvé spustenie: vytvoríme všetky tabuľky (migrate) a hneď ich
    # naplníme ukážkovými dátami (--seed spustí DatabaseSeeder).
    # --force = Laravel sa inak pýta na potvrdenie, keď APP_ENV=production.
    echo "[entrypoint] Prvé spustenie: vytváram tabuľky a importujem ukážkové dáta..."
    php artisan migrate --seed --force
else
    # Ďalšie spustenia: len doplníme nové migrácie (ak nejaké pribudli).
    # Seed už NESPÚŠŤAME, aby sa dáta neduplikovali a neprepísali zmeny,
    # ktoré medzitým urobil admin.
    echo "[entrypoint] Databáza už existuje, spúšťam len nové migrácie..."
    php artisan migrate --force
fi


# -----------------------------------------------------------------------------
# 5. SPUSTENIE HLAVNÉHO PROCESU
# -----------------------------------------------------------------------------
# "$@" sú argumenty z CMD v Dockerfile, teda "php-fpm".
# exec = php-fpm nahradí tento skript (dostane PID 1), takže správne
# prijíma signály od Dockeru (napr. pri "docker compose stop").
echo "[entrypoint] Hotovo, spúšťam: $*"
exec "$@"
