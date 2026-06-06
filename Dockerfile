FROM dunglas/frankenphp:php8.2-bookworm

# Install system dependencies and PHP intl extension
RUN apt-get update && apt-get install -y \
    libicu-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Copy application code
COPY . .

# Use PHP built-in server pointing to public directory (matches existing Procfile)
CMD php -S 0.0.0.0:${PORT:-80} -t public
