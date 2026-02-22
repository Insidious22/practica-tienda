FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY --from=assets /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
