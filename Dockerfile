# Use official PHP Apache image
FROM php:8.2-apache

# Install necessary system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite gd

# Enable Apache mod_rewrite for routing
RUN a2enmod rewrite

# Setup Document Root to match our structure
ENV APACHE_DOCUMENT_ROOT /var/www/html/medicare-app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy all project files into the container
COPY . /var/www/html/

# Set proper permissions for the application and database
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80
