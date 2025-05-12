FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set the working directory to the app folder
WORKDIR /var/www/html

# Copy the project files into the container
COPY . /var/www/html

# Set permissions (CodeIgniter requires writable permissions on writable/)
RUN chown -R www-data:www-data /var/www/html/writable

# Set the Apache document root to /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to use new document root
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Install Composer (if not already installed)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies using Composer
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Expose port 80
EXPOSE 80
