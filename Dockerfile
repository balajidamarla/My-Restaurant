FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Set permissions (CodeIgniter requires writable permissions on writable/)
RUN chown -R www-data:www-data /var/www/html/writable

# Set the Apache document root to /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use new document root
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Optional: Install Composer and dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

EXPOSE 80
