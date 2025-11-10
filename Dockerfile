# Use an official PHP 8.2 image with necessary extensions
FROM php:8.2-cli

# Install system dependencies required for Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev libzip-dev curl nodejs npm \
    && docker-php-ext-install pdo_mysql

# Copy Composer from the official composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory inside the container
WORKDIR /var/www/html

# Configure Git to trust the project directory to avoid "dubious ownership" warnings
RUN git config --global --add safe.directory /var/www/html

# Copy all project files into the container
COPY . .

# Install PHP dependencies using Composer
RUN composer install

# Install Node.js dependencies and build assets (optional for production)
RUN npm install && npm run build

# Expose port 80 so the Laravel dev server is accessible
EXPOSE 80

# Start Laravel's built-in development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
