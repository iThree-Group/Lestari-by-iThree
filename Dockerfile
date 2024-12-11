# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi yang diperlukan, misalnya mysqli untuk MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Tambahkan ServerName ke konfigurasi Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js dan npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Salin semua file proyek ke /var/www/html
COPY . /var/www/html

# Atur hak akses
RUN chown -R www-data:www-data /var/www/html

# Aktifkan modul Apache rewrite
RUN a2enmod rewrite

# Jalankan composer update
RUN composer update --working-dir=/var/www/html

# Jalankan npm install
RUN npm install --prefix /var/www/html

# Tentukan port untuk aplikasi
EXPOSE 80