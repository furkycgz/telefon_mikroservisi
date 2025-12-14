FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction

EXPOSE 8000

CMD sh -c " \
  php artisan key:generate --force && \
  echo 'MySQL bekleniyor...' && \
  sleep 15 && \
  php artisan migrate --force && \
  php artisan serve --host=0.0.0.0 --port=8000 \
"
