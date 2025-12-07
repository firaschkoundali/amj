FROM php:8.2-fpm

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

# Clear and warmup cache after installation
RUN php bin/console cache:clear --env=prod --no-interaction || true && \
    php bin/console cache:warmup --env=prod --no-interaction || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/var

# Expose port (Render uses $PORT environment variable)
EXPOSE 8000

# Start PHP built-in server (Render will set $PORT)
CMD php -S 0.0.0.0:${PORT:-8000} -t public

