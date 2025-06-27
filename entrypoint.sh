#!/bin/bash

# Copy the appropriate .env file (you can skip this if it's already committed)
echo "Using local environment"
cp /var/www/html/.env.example /var/www/html/.env

# Generate the application key
php artisan key:generate --ansi

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Dynamically set the Apache port (Heroku-style support)
if [ -z "${PORT}" ]; then
    export PORT=80
fi

# Update Apache to listen on the correct port
echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Start Apache (important to use exec here to replace the shell process)
exec apache2-foreground
