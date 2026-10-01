# Návod: Nový Laravel projekt v Docker (Revichillin)

## 1. Priprav priečinok
Vytvor nový, čistý priečinok, napr.:
```
C:\Users\Erik Gracák\Documents\VAII_semestralka\Revichillin
```
Skopíruj tam tieto 4 súbory/priečinky, presne tak ako sú:
- `Dockerfile`
- `docker-compose.yml`
- `.dockerignore`
- `docker/` (celý priečinok s podpriečinkom `nginx`)

## 2. Spusti PowerShell v tomto priečinku
Klikni pravým tlačidlom v priečinku (podrž Shift) → "Otvoriť okno PowerShell tu"
(alebo `cd "C:\Users\Erik Gracák\Documents\VAII_semestralka\Revichillin"`)

## 3. Postav Docker image
```powershell
docker compose build
```
Toto stiahne PHP, Composer a pripraví obraz. Prvýkrát to potrvá pár minút.

## 4. Vytvor nový Laravel projekt priamo cez kontajner
```powershell
docker compose run --rm app composer create-project laravel/laravel .
```
Toto stiahne čerstvý Laravel priamo do tvojho priečinka (nemusíš mať PHP/Composer nainštalované lokálne vôbec).

## 5. Spusti všetky kontajnery
```powershell
docker compose up -d
```

## 6. Uprav .env súbor
V Laravel priečinku sa vytvoril `.env` súbor. Otvor ho a uprav databázové nastavenia na:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=revichillin
DB_USERNAME=revichillin
DB_PASSWORD=revichillin
```
(meno hostiteľa je `db` - názov služby v docker-compose, nie `localhost` alebo `127.0.0.1`!)

## 7. Vygeneruj APP_KEY a spusti migrácie
```powershell
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

## 8. Over, že to funguje
Otvor v prehliadači:
- **Web (Laravel)**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080 (login: root / heslo: root)
- **Vite dev server** (ak používaš npm run dev): http://localhost:5173

## Bežné príkazy do budúcna
```powershell
docker compose up -d          # spustí všetko na pozadí
docker compose down           # zastaví všetko
docker compose exec app bash  # vojde do PHP kontajnera (napr. na artisan príkazy)
docker compose logs -f app    # sleduje logy PHP kontajnera
```

Všetky `php artisan` príkazy spúšťaj cez:
```powershell
docker compose exec app php artisan nazov:prikazu
```

Napr.:
```powershell
docker compose exec app php artisan make:model Product -m
docker compose exec app php artisan make:controller ProductController
```
