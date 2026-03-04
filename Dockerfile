FROM php:8.2-fpm

# Установка пакетов
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    nginx \
    && docker-php-ext-install pdo pdo_sqlite zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем проект
COPY . .

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader
RUN php artisan migrate --force

# Создаем sqlite
RUN touch database/database.sqlite

# Настройка nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Права
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 10000

CMD service nginx start && php-fpm