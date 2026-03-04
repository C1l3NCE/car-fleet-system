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

# Рабочая папка
WORKDIR /var/www

# Копируем проект
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader

# Создаём таблицу sessions (если её нет)
RUN php artisan session:table || true

# Настройка nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Права Laravel
RUN chmod -R 777 storage bootstrap/cache

# Открываем порт Render
EXPOSE 10000

# Запуск контейнера
CMD php artisan migrate --force || true && service nginx start && php-fpm