FROM php:8.2-fpm

# Установка пакетов
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем проект
COPY . .

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Настройка папок Laravel
RUN mkdir -p storage/logs \
    && touch storage/logs/laravel.log \
    && chmod -R 777 storage \
    && chmod -R 777 bootstrap/cache

# nginx конфиг
COPY nginx.conf /etc/nginx/sites-available/default

# Создаём таблицу sessions если её нет
RUN php artisan session:table || true

EXPOSE 10000

CMD php artisan migrate:fresh --force && service nginx start && php-fpm