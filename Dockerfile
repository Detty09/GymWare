# ---- 1️⃣ PHP + Apache alap ----
FROM php:8.2-apache AS app

# Rendszerfüggőségek + PHP kiterjesztések
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo_mysql

# Apache rewrite engedélyezése
RUN a2enmod rewrite

# Composer bemásolása
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Munkakönyvtár
WORKDIR /var/www/html

# Laravel fájlok másolása
COPY . .

# Függőségek telepítése
RUN composer install --no-dev --optimize-autoloader

# Storage és cache mappák jogosultsága
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Public mappára mutasson az Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Port megnyitása
EXPOSE 80

# ---- 2️⃣ Node / Vite build ----
FROM node:20 AS frontend

WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm install
COPY resources ./resources
RUN npm run build

# ---- 3️⃣ Production image ----
FROM app AS final

# Buildelt frontend másolása
COPY --from=frontend /app/public/build ./public/build

# Default indítás
CMD ["apache2-foreground"]
