FROM php:8.4-fpm-alpine

# Install system + build dependencies
RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    libzip-dev \
    oniguruma-dev \
    libxml2-dev \
    zlib-dev \
    icu-dev \
    nodejs \
    npm \
    $PHPIZE_DEPS

# Install PHP extensions (split to avoid errors)
RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install xml

RUN docker-php-ext-install ctype

RUN docker-php-ext-install fileinfo

# Fix for zip (IMPORTANT)
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

# Remove build dependencies
RUN apk del $PHPIZE_DEPS

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Fix permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
