# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi yang diperlukan
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    && docker-php-ext-install mysqli pdo pdo_mysql mbstring

# Tambahkan ServerName ke konfigurasi Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file composer.json dan composer.lock terlebih dahulu
COPY composer.json composer.lock /var/www/html/

# Atur hak akses
RUN chown -R www-data:www-data /var/www/html

# Jalankan composer install
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html || true

# Salin semua file proyek ke /var/www/html
COPY . /var/www/html

# Aktifkan modul Apache rewrite
RUN a2enmod rewrite

# Tentukan port untuk aplikasi
EXPOSE 80