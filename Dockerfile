FROM php:8.2-fpm

# Установка пакетов
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем проект
COPY . .

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Права Laravel
RUN mkdir -p storage/logs \
    && touch storage/logs/laravel.log \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# nginx конфиг
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 10000

CMD service nginx start && php-fpm