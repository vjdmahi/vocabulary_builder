# 1️⃣ Start from PHP 8.2 FPM Alpine (lightweight)
FROM php:8.2-fpm-alpine

# 2️⃣ Install system packages & PHP extensions needed by Laravel
RUN apk add --no-cache \
        bash \
        git \
        curl \
        unzip \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev \
        npm \
        nodejs \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        tokenizer \
        xml \
        ctype \
        fileinfo \
        zip

# 3️⃣ Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Set working directory
WORKDIR /var/www

# 5️⃣ Copy Laravel project into container
COPY . .

# 6️⃣ Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# 7️⃣ Fix permissions for Laravel storage & cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 8️⃣ Expose container port 9000 for PHP-FPM
EXPOSE 9000

# 9️⃣ Default command (PHP-FPM)
CMD ["php-fpm"]
