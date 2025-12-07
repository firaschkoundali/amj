FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Create minimal .env file for build (will be overridden by environment variables at runtime)
RUN echo "APP_ENV=prod" > .env && \
    echo "APP_SECRET=temp_secret_for_build_only" >> .env && \
    echo "DATABASE_URL=postgresql://user:pass@localhost/db" >> .env

# Install dependencies (skip scripts to avoid cache:clear during build)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Note: Cache will be warmed up automatically on first request when APP_ENV=prod
# We don't warmup during build because environment variables are not yet set

# Create var directory if it doesn't exist (for cache, logs, etc.)
RUN mkdir -p /var/www/html/var/cache /var/www/html/var/log

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/var

# Expose port (Render uses $PORT environment variable)
EXPOSE 8000

# Create entrypoint script
RUN echo '#!/bin/sh\n\
set -e\n\
\n\
# Clear and warmup cache on startup\n\
php bin/console cache:clear --env=prod --no-interaction || true\n\
php bin/console cache:warmup --env=prod --no-interaction || true\n\
\n\
# Start PHP built-in server\n\
exec php -S 0.0.0.0:${PORT:-8000} -t public\n\
' > /entrypoint.sh && chmod +x /entrypoint.sh

# Start PHP built-in server (Render will set $PORT)
CMD ["/entrypoint.sh"]

