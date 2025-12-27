# Use multi-stage build for production
FROM php:8.2-fpm as base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip gd pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy package files
COPY package.json package-lock.json ./
RUN npm ci && npm run build

# Copy project
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate app key if not set
RUN php artisan key:generate --no-interaction

# Clear and cache config/routes/views
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Production stage
FROM base as production

# Install nginx
RUN apt-get update && apt-get install -y nginx \
    && rm -rf /var/lib/apt/lists/*

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-available/default

# Expose port
EXPOSE 80

# Start nginx and php-fpm
CMD service nginx start && php-fpm
