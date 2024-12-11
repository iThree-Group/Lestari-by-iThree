# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi yang diperlukan, misalnya mysqli untuk MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Tambahkan ServerName ke konfigurasi Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy file composer ke container
COPY composer.json composer.lock ./

# Install dependencies PHP
RUN composer install --no-scripts --no-autoloader

# Salin semua file proyek ke /var/www/html
COPY . /var/www/html

# Jalankan perintah composer update
RUN composer update

# Atur hak akses
RUN chown -R www-data:www-data /var/www/html

# Aktifkan modul Apache rewrite
RUN a2enmod rewrite

# Install Node.js dan npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

# Copy file package.json dan package-lock.json ke container
COPY package.json package-lock.json ./

# Install dependencies JavaScript
RUN npm install

# Tentukan port untuk aplikasi
EXPOSE 80