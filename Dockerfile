FROM php:7.3-apache

# Install mysqli & pdo_mysql
RUN docker-php-ext-install mysqli

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Copy source code
COPY . /var/www/html

# Permission
RUN chown -R www-data:www-data /var/www/html

# Copy php.ini
COPY php.ini /usr/local/etc/php/

EXPOSE 80
