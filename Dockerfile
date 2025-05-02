FROM php:8.2-fpm-alpine

WORKDIR /app

RUN apk add --no-cache --update linux-headers \
    libpq-dev \
    zlib-dev \
    libpng-dev \
    nginx \
    supervisor \
    && docker-php-ext-install -j$(nproc) pdo_mysql pdo_pgsql bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files BEFORE composer install
COPY . /app

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Explicitly dump the autoloader
RUN composer dump-autoload --optimize

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy Supervisor configuration
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage /app/bootstrap/cache

# Run Laravel specific commands AFTER composer install
RUN php artisan optimize:clear \
    && php artisan package:discover --ansi \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]