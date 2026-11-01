FROM php:8.3-fpm

# Systémové závislosti
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www

# Composer beží v kontajneri ako root - bez tejto premennej by pri každom
# "composer install" vypisoval varovanie a čakal na potvrdenie.
ENV COMPOSER_ALLOW_SUPERUSER=1

# Entrypoint skript (pripraví .env, vendor/, DB a ukážkové dáta - viď komentáre
# v docker/entrypoint.sh). Kopírujeme ho MIMO /var/www, pretože /var/www
# v docker-compose.yml prekryje namapovaný priečinok projektu.
# sed odstráni prípadné Windows konce riadkov (\r), s ktorými by sh skript
# nevedel spustiť. chmod +x = skript bude spustiteľný.
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint \
    && chmod +x /usr/local/bin/docker-entrypoint

EXPOSE 9000

# ENTRYPOINT sa spustí pri štarte kontajnera a ako argument dostane CMD.
# Výsledok: docker-entrypoint php-fpm -> skript pripraví aplikáciu
# a na konci cez "exec php-fpm" spustí samotný PHP server.
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
