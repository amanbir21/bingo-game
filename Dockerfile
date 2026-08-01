FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip curl nodejs npm libzip-dev \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

CMD php artisan serve --host 0.0.0.0 --port $PORT