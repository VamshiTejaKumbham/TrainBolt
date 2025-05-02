FROM php:8.2-fpm-alpine

WORKDIR /app

RUN apk add --no-cache --update linux-headers \
    libpq-dev \
    zlib-dev \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql pdo_pgsql bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . /app

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Run Laravel specific commands AFTER composer install
RUN php artisan optimize:clear \
    && php artisan package:discover --ansi \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 9000

CMD ["php-fpm"]