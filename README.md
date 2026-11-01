# Revichillin

Semestrálna práca z predmetu VAII: e-shop postavený na Laravel 13 (PHP 8.3) s administráciou cez Filament 5.

## Funkcie

- katalóg produktov s filtrovaním a detailom produktu
- registrácia, prihlásenie a profil používateľa
- košík a objednávky
- recenzie produktov
- admin panel na `/admin` (produkty, objednávky, recenzie, používatelia, číselníky)

## Spustenie

Potrebný je iba Docker.

```sh
docker compose up -d --build
```

Pri prvom spustení sa automaticky nainštalujú závislosti, vytvorí sa `.env`, vygeneruje sa `APP_KEY` a databáza sa naplní ukážkovými dátami.

| Služba | Adresa |
|---|---|
| Web | http://localhost:8000 |
| Admin panel | http://localhost:8000/admin |
| phpMyAdmin | http://localhost:8080 |

## Prihlasovacie údaje (ukážkové dáta)

| Rola | E-mail | Heslo |
|---|---|---|
| Admin | admin@example.com | password |
| Zákazník | test@example.com | password |

## Užitočné príkazy

```sh
docker compose down                                          # zastavenie
docker exec -u www-data revichillin_app php artisan test     # testy
docker exec -u www-data revichillin_app php artisan migrate:fresh --seed   # reset databázy
```

Artisan príkazy spúšťaj ako `www-data` (`-u www-data`), inak vzniknú v `storage/` súbory patriace rootovi.
