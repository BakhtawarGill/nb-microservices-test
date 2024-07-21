# Use the official PHP image as the base image
FROM php:8.3-fpm

# Copy custom php.ini
COPY php.ini /usr/local/etc/php/
# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    librdkafka-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN pecl install -o -f rdkafka \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable rdkafka
# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# Copy the existing application directory contents to the working directory
COPY . .

# Expose port 8000 and start php-fpm server
EXPOSE 8000
CMD ["php-fpm"]
