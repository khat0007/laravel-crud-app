FROM php:8.2-apache

# 1. Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        git \
        curl \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# 2. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# 3. Apache configuration
RUN a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy ONLY composer files first (to leverage Docker cache)
COPY composer.json composer.lock ./

# 6. Install PHP dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts

# 7. Copy all application files
COPY . .

# 8. Install Node.js and npm (for Laravel Mix or npm commands)
RUN apt-get update && apt-get install -y curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


# 9. Run post-install scripts
RUN composer run-script post-autoload-dump

# 10. (Optional) Build frontend assets
# RUN npm install && npm run build

# 11. # Set correct permissions for storage and cache
      RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
       && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
EXPOSE 80

CMD ["apache2-foreground"]
