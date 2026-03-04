FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Установка composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем проект
COPY . .

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Создаем нужные папки Laravel
RUN mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Права для Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# nginx конфиг
COPY nginx.conf /etc/nginx/sites-available/default

# Порт render
EXPOSE 10000

# Запуск
CMD php artisan migrate --force || true && service nginx start && php-fpm